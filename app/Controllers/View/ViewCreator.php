<?php


namespace App\Controllers\View;


use App\Controllers\BaseController;
use App\Controllers\ConstantBase;
use App\Controllers\Organizer\Organizer;
use App\Controllers\Session;

class ViewCreator extends BaseController
{

    public $ConstantBase;
    public $currentBase;
    public $assetsBase;
    public $cssBase;
    public $imagePath;
    public $SessionController;
    private $viewLogic;

    public function __construct()
    {
        $this->ConstantBase = new ConstantBase();
        $this->currentBase = $this->ConstantBase->ConstantInfo->currentBase();
        $this->imagePath = $this->ConstantBase->ConstantInfo->imageFolderBase;
        $this->viewLogic = new ViewLogic();
        $this->assetsBase = getenv('ASSETS_BASE');
        $this->cssBase = getenv('CSS_FOLDER_BASE');
        $this->SessionController = new Session();
    }

    private function header_metas($headerMetas)
    {
        $prepare = '';
        // Meta tagların bulunduğu diziyi bir döngü içerisine alıyoruz
        foreach ($headerMetas as $headerMeta) {
            // meta dizisi 3 bölümden oluştuğu bir kez daha döngü içerisine alıyoruz ve
            foreach ($headerMeta as $subMeta) {
                // bölümlerin içerisinde bulunan meta bilgileride ufak bir dizi içerisinde olduğu için
                // ilk olarak meta tagımızı açıyoruz daha sonra döngüdeki $key değişkeni
                // name , property gibi anahtarlara karşılık gelmektedir. Bu anahtarları değişkenleri ile birlikte meta satırına yazdırıyoruz..
                $prepare .= '<meta ';
                foreach ($subMeta as $key => $subContent) {
                    $prepare .= $key . "=\"$subContent\"" . " ";
                }
                $prepare .= ' />
                ';
            }
        }
        return $prepare;
    }

    private function header_title($titleInfo)
    {
        return '<title>' . $titleInfo . '</title>';
    }

    private function header_links($links)
    {
        $prepare = '';
        foreach ($links as $link) {
            $prepare .= link_tag($link);
        }
        return $prepare;
    }

    public function header($data = [])
    {
        helper(['html']);
        $data['docType'] = doctype();
        $data['htmlStart'] = '<html lang="tr">
                            <head>';

        $data['header_metas'] = $this->header_metas($data['header_metas']);
        $data['titleInfo'] = $this->header_title($data['titleInfo']);
        $data['linksTag'] = $this->header_links($data['linksTag']);
        return $data;

    }

    private function seo_data($data, $which)
    {
        $seo = [];
        if ($which == 'content') {
            // içerikte bulunabilecek görsel vb.. işraretlemeleri kaldırdıktan sonra ilgili içeriğin
            // sadece 500 karakterini aktarıyoruz..
            $data['description'] = substr(strip_tags($data['description']), 0, 500);
        }
        if ($which == 'card') {
            $seo['description'] = '';
            foreach ($data as $value) {
                $seo['description'] .= $value['title'] . ', ';
            }
            $data = $seo;
        }
        return $data;
    }

    private function dashboardPanelLinks($isLogged)
    {
        if ($isLogged) {
            $segments = $this->viewLogic->uriGetter();
            $pagesRender = $this->viewLogic->dashboardElementChecker($segments);
            $contentForDashboard = (new Organizer())->internalCall(); //$this->SessionController->getSession('userData');
            $countContent = !empty($contentForDashboard['contentForDashboard']) ? count($contentForDashboard['contentForDashboard']) : 0;
            unset($contentForDashboard);
            $pagesRender['contentsCount'] = $countContent;
            return $pagesRender;
        }

    }

    public function nav($navData = [])
    {
        $navData['currentBase'] = $this->currentBase;
        $link = $navData['userInfo']['isLoggedIn'] ? '/users/profile' : '/users/login';
        $loginButtonText = !$navData['userInfo']['isLoggedIn'] ? lang('View.login.index.login') : $navData['userInfo']['firstname'];
        $navData['isActive'] = $this->dashboardPanelLinks($navData['userInfo']['isLoggedIn']);
        $navData['loginButton'] = ['link' => $link, 'buttonText' => $loginButtonText];
        $navData['isAdmin'] = $navData['userInfo']['role'] == 'admin';

        $navData['SITE_NAME'] = getenv('SITE_NAME');
        return $navData;
    }

    public function login_form_looper($formData = [])
    {
        $data = [];
        $data['form_open'] = $formData['form_open'];
        $data['loginLogoLink'] = $formData['loginLogoLink'];
        $data['signinCss'] = $formData['signinCss'];
        $completedForm = '';
        foreach ($formData['inputAndLabel'] as $value) {
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    $completedForm .= $subValue;
                }
            } else {
                $completedForm .= $value;
            }
        }
        $data['formReady'] = $completedForm;
        $data['form_close'] = $formData['form_close'];
        return $data;
    }

    public function register_form_looper($formData = [])
    {
        $data = [];
        $data['form_open'] = $formData['form_open'];
        $completedForm = [];
        foreach ($formData['inputAndLabel'] as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $completedForm[$key][$subKey] = $subValue;
                }
            } else {
                $completedForm[$key] = $value;
            }
        }
        $data['formReady'] = $completedForm;
        $data['form_close'] = $formData['form_close'];
        $data['captcha_site_key'] = getenv('capctcha_site_key');
        return $data;
    }

    // card_looper fonksiyonu, anasayfa , herkese açık profil ve kullanıcı panelinde kullanılır.
    public function card_looper($anyData = [])
    {
        $looped = $this->viewLogic->cardLogic($anyData, $this->ConstantBase->ConstantInfo);
        $seo = !empty($looped['contentSummary']) ? $looped['contentSummary'] : [];
        $looped['seo']['header'] = $this->seo_data($seo, 'card');
        return $looped;
    }

    public function dasboard_contents_looper($anyData = [])
    {
        $data = [];
        $contentForDashBoard = [];
        if (!empty($anyData['userData']['contentForDashboard'])) {
            $contentForDashBoard = $anyData['userData']['contentForDashboard'];
            foreach ($contentForDashBoard as $key => $value) {
                $data['contentForDashboard'][$key]['title'] = $value->title;
                $data['contentForDashboard'][$key]['slug'] = $value->slug;
                $data['contentForDashboard'][$key]['content'] = strip_tags($value->content);
                $data['contentForDashboard'][$key]['created_at'] = $value->created_at;
            }
        }

        if (!empty($anyData['userData']['userResultForCommentMerged'])) {
            $mergedComment = $anyData['userData']['userResultForCommentMerged'];
            foreach ($mergedComment as $key => $value) {
                if (!empty($contentForDashBoard[$value->notification_where_id]) && $value->notification_where == 'content_id' && $value->notification_field == 'comments') {
                    $data['commentForDashBoard'][$key]['ContetOwnerSlug'] = $contentForDashBoard[$value->notification_where_id]->slug;
                    $data['commentForDashBoard'][$key]['ContetOwnerTitle'] = $contentForDashBoard[$value->notification_where_id]->title;
                    $data['commentForDashBoard'][$key]['postRead'] = 'postRead(' . $value->notification_where_id . ')';
                    $data['commentForDashBoard'][$key]['notificationLinkTargetId'] = $value->notification_field_id;
                    $data['commentForDashBoard'][$key]['commentOwner'] = $value->user_name;
                }
            }
        }

        return $data;
    }

    public function public_content_looper($anyData = [])
    {
        $data = [];
        if (!empty($anyData['publicResult'])) {
            // Herkese açık içerik..
            $data['publicResult']['content'] = $anyData['publicResult'][0];
            // Herkese açık içeriğin sahip bilgileri
            $data['publicResult']['ContentsUserInfo'] = $anyData['publicResult']['ContentsUserInfo'];
            // Görüntüleyen ziyaretçinin giriş yapma kontrolü ve giriş yapmışsa kullanıcı kimliğini değişkene atama
            $currentUserId = $this->SessionController->getSession('userInfo')['user_id'];
            $isAdmin = $this->SessionController->getSession('userInfo')['role'] == 'admin' ? 1 : 0;
            // İçerik sahibi kendi içeriğini herkese açık yayımlanmış haliyle ziyaret ettiğinde o anki sayfadadan sahiplik
            // kontrolü yapılarak düzenleme butonu görüntüleme şart kontrolü
            $data['publicResult']['content']['editable'] = $data['publicResult']['content']['user_id'] == $currentUserId;
            // Eğer içerğe ait yorum varsa burada belirlenir.
            $data['allComments'] = !empty($anyData['mergedCommentForBoth']) ? $anyData['mergedCommentForBoth'] : [];
            // Eğer yorum var ise mantıksal sorgulamalar döngü içerisinde başlar..
            if (!empty($data['allComments'])) {
                foreach ($data['allComments'] as $key => $value) {
                    // Buradaki şart kontrolü yorum ve içerik sahibine ait olup olmadığının kontrolüdür
                    // Eğer buradaki koşullar sağlanırsa içeriği silmeye yetkili kişilerin kullanılması için
                    // silme parametresi olarak yorum bilgi işlenir.
                    if (
                        $isAdmin == 1
                        ||
                        $currentUserId == $data['publicResult']['ContentsUserInfo']['user_id']
                        ||
                        ($data['allComments'][$key]->user_id == $currentUserId)
                    ) {
                        $data['allComments'][$key]->isCommentOwner = $value->comment_id;
                    }
                    // allComment dizisinden yorum sahibine kolayca ulaşabilmek için şart ve döngüler ile
                    // birleştirme yapılır..
                    if (!empty($anyData['commentedUserInfo'])) {
                        foreach ($anyData['commentedUserInfo'] as $key => $value) {
                            if ($value['user_id'] == $data['allComments'][$key]->user_id) {
                                $value['icon_name'] = $this->ConstantBase->ConstantInfo->getIconState() . $value['icon_name'];
                                $data['allComments'][$key]->commentedUser = $value;
                            }
                        }
                    }
                }
            }
            $seo['description'] = $data['publicResult']['content']['content'];
            $seo['content_title'] = $data['publicResult']['content']['title'];
            $seo['titleInfo'] = $data['publicResult']['content']['title'];
            $seo['content_owner_full_name'] = $data['publicResult']['ContentsUserInfo']['firstname'] . ' ' . $data['publicResult']['ContentsUserInfo']['lastname'];
            $seo['content_owner'] = $data['publicResult']['ContentsUserInfo']['user_name'];
            $seo['content_title_image'] = $data['publicResult']['content']['title_image'];
            $seo['content_images'] = explode(",", $data['publicResult']['content']['content_images']);
            $seo['currentImagePathForSEO'] = $this->currentBase . $this->imagePath;
            $seo['content_date']['createdAt'] = $data['publicResult']['content']['created_at'];
            $seo['content_date']['updatedAt'] = !empty($data['publicResult']['content']['updated_at']) ? $data['publicResult']['content']['updated_at'] : $data['publicResult']['content']['created_at'];
            $data['seo']['header'] = $this->seo_data($seo, 'content');
            $data['currentEditorCssLink'] = $this->currentBase . 'public/assets/editor/dist/css/quill.snow.1.3.6.css';
            return $data;
        }

    }

    public function footer($data)
    {
        $data['footer']['baseUrl'] = base_url();
        $data['footer']['SITE_NAME'] = getenv('SITE_NAME');

        return $this->footer_scripts($data);
    }

    private function footer_scripts($scriptTag)
    {
        $prepare = '';
        foreach ($scriptTag['script_tag'] as $scriptlink) {
            $prepare .= script_tag($scriptlink);
        }
        $scriptTag['script_tag'] = $prepare;
        return $scriptTag;
    }

}