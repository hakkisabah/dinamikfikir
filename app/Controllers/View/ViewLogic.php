<?php


namespace App\Controllers\View;


use App\Controllers\Extension\Uploader;
use App\Controllers\Organizer\ModelCaller;

class ViewLogic
{

    public function uriGetter()
    {
        $uri = service('uri');
        $segments = $uri->getSegments();
        unset($uri);
        return $segments;
    }

    public function dashboardElementChecker($segments)
    {
        $pagesName = ['dashboard', 'contents', 'editor'];
        if (isset($segments[0])) {
            $segemented['segementOne'] = !isset($segments[1]) && array_search($segments[0], $pagesName) !== false ? $segments[0] : '';
            $segemented['segementTwo'] = isset($segments[1]) && array_search($segments[0], $pagesName) !== false && array_search($segments[1], $pagesName) !== false ? $segments[1] : '';

            $data['dashboard'] = $segemented['segementOne'] != '' ? ' active' : '';
            $data['contents'] = $segemented['segementTwo'] == 'contents' ? ' active' : '';
            $data['editor'] = $segemented['segementTwo'] == 'editor' ? ' active' : '';
            $data['AdminSite'] = $segemented['segementTwo'] == 'site' ? ' active' : '';
            $data['AdminUsers'] = $segemented['segementTwo'] == 'users' ? ' active' : '';
        } else {
            $data['dashboard'] = '';
            $data['contents'] = '';
            $data['editor'] = '';
            $data['AdminSite'] = '';
            $data['AdminUsers'] = '';
        }
        return $data;

    }

    private function virtualizeImages($anyData)
    {
//        foreach ($anyData as $key => $value) {
        if (!empty($anyData->content_images) && $anyData->is_local_image != getenv('UPLOAD_LOCATION')) {
            // içerikteki tüm görsel içeriklerin kaynak hedeflerini getiriyoruz
            preg_match_all('/<img src="(.*?)"/i', $anyData->content, $match);
            $remoteDomain = explode('/', getenv('REMOTE_PUBLIC_BASE_ADDRESS'));
            $localDomain = explode('/', base_url());
            $currentLocation = getenv('UPLOAD_LOCATION') != 'LOCAL' ? $remoteDomain : $localDomain;
            // to Change
            $isHttpsOtherDomain = $currentLocation[0] . '//';
            $toChanging = preg_quote($isHttpsOtherDomain, '/') . $currentLocation[2];


            // Eğer birden fazla link varsa bunu dönen değerin 1. dizisinden kontrol ediyoruz.
            if (!empty($match[1]) && is_array($match[1])) {
                // diziyi domainle eşleşmeyen diziler var ise çıkartmak için döngüye alıyoruz var ise çıkartıyoruz.
                foreach ($match[1] as $subVal) {
                    // her değer içindeki domaini belirliyoruz
                    $domain = explode('/', $subVal)[2];
                    // daha sonra alınan domain değerinin boş olup olmadığını kontrol edip mantıksal sınamaya sokuyoruz
                    if (empty($domain)) {
                        unset($match[1][$subVal]);
                    }
                    if ($currentLocation[2] != $domain) {
                        // mantıksal sınamada eşleşmeyenleri kaldırıyoruz
                        unset($match[1][$subVal]);
                    }

                }
                // döngü sonrası dizi sıralaması değişebileceğinden bunu tekrar sıraya koyuyoruz.
                array_values($match[1]);
                // ssl sınamasına alarak tekrar domainleri değişkene alıyoruz
                // sıralanmış dizinin ilk elemenını örnek olarak işlemek için $match[1][0] kullanıyoruz.
                // local
                $isHttpsOwnDomain = explode('/', $match[1][0])[0] . '//';
                $domain = explode('/', $match[1][0])[2];
                $pattterns = '/' . preg_quote($isHttpsOwnDomain, '/') . preg_quote($domain, '/') . '/';

                // preg_quote() methoduyla eklenen \ işaretini stripcslashes yardımıyla kaldırıyoruz ve eşleşen sonuçları
                // gönderilen parametreye ait objeye aktarıyoruz

                $anyData->content = stripcslashes(preg_replace($pattterns, $toChanging, $anyData->content));
                $anyData->is_local_image = getenv('UPLOAD_LOCATION');

            }
            return $anyData;
        }
//        }
    }

    private function simulateLocationChange($anyData)
    {
        $virtualizedData = $anyData;
        $ModelCaller = new ModelCaller();
        $Uploader = new Uploader();
        foreach ($virtualizedData as $key => $value) {
            if (!empty($value->content_images) && $value->is_local_image != getenv('UPLOAD_LOCATION')) {

                $currentContent = $ModelCaller->ContentModel->where('content_id', $value->content_id)->find()[0];
                $newData['title'] = $currentContent['title_image'];

                $newData['editor'] = explode(',', $currentContent['content_images']);

                $isOkVirtualize = $this->virtualizeImages($value);

                $ModelCaller->ContentModel
                    ->where('content_id', $value->content_id)
                    ->set((array)$isOkVirtualize)
                    ->update();

                $virtualizedData[$key] = $isOkVirtualize;

                $Uploader->changeLocation($newData);


            }
        }
        return $virtualizedData;
        unset($Uploader);
        unset($ModelCaller);
    }

    private function content_arranger_for_card_looper($anyData, $whichKey, $segment = [], $ConstantInfo)
    {
        $data = [];
        if (!empty($anyData[$whichKey])) {
            $anyData[$whichKey] = $this->simulateLocationChange($anyData[$whichKey]);
            foreach ($anyData[$whichKey] as $key => $value) {

                $data['contentSummary'][$value->content_id] = [
                    'publicTitleImageAddress' => $ConstantInfo->publicTitleImageAddress((array)$value),
                    'viewButtonLink' => "onclick=\"location.href='/content/" . $value->slug . "'\"",
                    'editButtonLink' => "onclick=\"location.href='/dashboard/editor/" . $value->slug . "'\"",
                    'deleteButtonLink' => "onclick=\"location.href='/dashboard/deletecontent/" . $value->slug . "'\"",
                    'title' => $value->title,
                    'slug' => $value->slug,
                    'createdAt' => $value->created_at,
                ];
                if (!empty($anyData['loggedUserInfo']) && $anyData['loggedUserInfo']['user_id'] == $value->user_id) {
                    $data['contentSummary'][$value->content_id]['editable'] = true;
                    $data['contentSummary'][$value->content_id]['segment'] = $segment;
                }
            }
            // Herkese açık kullanıcı profili ziyaret edildiğinde gösterilecek ikon adresiyle birlikte verilir.
            if (!empty($segment['publicProfile'])) {
                $data['userIconAddress'] = $anyData['userIconAddress'];
                $data['fullName'] = $anyData['fullName'];
            }
        }
        return $data;
    }

    public function cardLogic($anyData, $ConstantInfo)
    {

        // URL'nin tam olarak nerede olunduğunu görebilmek için uriGetter
        $uriGetter = $this->uriGetter();
        // ve url parametrelerini alabilmek için dashboardElementChecker fonksiyonundan yararlarnıyoruz.
        // Burada tek bir farkı hatırlatmakta önem var.
        // herkese açık profil sayfasında sessiondaki bilgiler alınmaz $anyData['contentData'] değişkeninden
        // ve veritabanından çekilmiş son bilgiler kullanılır.
        $segment = $this->dashboardElementChecker($uriGetter);
        $userInfo = !empty($anyData['userInfo']) ? $anyData['userInfo'] : false;

        if (!isset($uriGetter[0])) {
            if (!empty($anyData['indexData'])) {
                unset($anyData['userData']);
                unset($anyData['contentData']);
                return $this->content_arranger_for_card_looper($anyData, 'indexData', $segment, $ConstantInfo);
            }
        } else {
            // Eğer url parametresi var ise parametre ve değişken kontrolleri yapılır
            if ($segment['dashboard'] != '') {
                unset($anyData['indexData']);
                unset($anyData['contentData']);
                $anyData['userData']['loggedUserInfo'] = $anyData['loggedUserInfo'];
                return $this->content_arranger_for_card_looper($anyData['userData'], 'contentForDashboard', $segment, $ConstantInfo);
            }
            // Not : Buradaki gelecek veri, veri tabanından gelir, diğerleri sessiondan.
            if (!empty($anyData['contentData'])) {
                unset($anyData['userData']);
                unset($anyData['indexData']);
                $anyData['userIconAddress'] = $ConstantInfo->getIconState() . $userInfo['icon_name'];
                $anyData['fullName'] = $userInfo['firstname'] . ' ' . $userInfo['lastname'];
                $segment['publicProfile'] = true;
                return $this->content_arranger_for_card_looper($anyData, 'contentData', $segment, $ConstantInfo);
            }
        }
        return $anyData;
    }
}