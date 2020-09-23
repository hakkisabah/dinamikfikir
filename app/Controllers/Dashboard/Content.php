<?php


namespace App\Controllers\Dashboard;

use App\Controllers\Extension\Uploader;
use App\Controllers\Organizer\ModelCaller;
//use App\Controllers\Organizer\Organizer;

/**
 * Class Content
 * @package App\Controllers\Dashboard
 */
class Content implements Contents
{
    // Önemli not
    // $uploader = new Uploader(); işlemi her ihtiyaç duyulduğunda bu sınıfta kullanılmış olup
    // Kullanıldıktan sonra unset edilmiştir.. Bunun sebebi AWS S3 sınıfyla geçtiği iletişime bağlı ortalama 6 mb yer kaplıyor olmasıdır..
    // __construct() metodunda kullanılması önerilmez ve performans açısından önemlidir..
    /**
     * @var ModelCaller
     */
    private $ModelCaller;

    /**
     * Content constructor.
     */
    public function __construct()
    {
        $this->ModelCaller = new ModelCaller();
    }

    /**
     * @param $contentImages
     * @param $content
     * @return bool
     */
    private function lastContentImagesChecker($contentImages,$content)
    {
        foreach ($contentImages as $key => $value){
            preg_match_all('/'.$value.'/i', $content, $match);
            if (empty($match[0])) {
                unset($contentImages[$key]);
            }
        }
        return implode(',',$contentImages);
    }

    public function setContent(object $request)
    {
        $titleImageName = '';
        $editorImages = '';
        if (!empty($request->getVar('editorImagesHidden'))){
            $editorImages = $this->lastContentImagesChecker(explode(',',$request->getVar('editorImagesHidden')),$request->getVar('contentHiddenForDiv'));
        }
        try {
            $imageLogic = new ImageLogic();
            $images = $imageLogic->checkAndCopyImage();
            $titleImageName = $images['titleImageNameHere'];
        } catch (ReflectionException $e) {

        }
        $newData = [
            'content' => $request->getVar('contentHiddenForDiv'),
            'title' => $request->getVar('title'),
            'slug' => $this->slugify($request->getVar('title')),
            'title_image' => $titleImageName,
            'content_images' => $editorImages,
            'user_id' => session()->get('userInfo')['user_id'],
            'is_local_image' => getenv('UPLOAD_LOCATION'),
        ];
        try {
            $this->ModelCaller->ContentModel->save($newData);
            $imageLogic = new ImageLogic();
            // içerik yüklendikten sonra herhangi bir lokasyon değişikliği gerçekleşmişse
            // bunu düzeltmek için changeLocationIfDifferent() methodunu işi garantiye almak için çalışıtırıyoruz.
            $imageLogic->changeLocationIfDifferent($this->getContent('slug', $newData['slug']));
            unset($imageLogic);
            return true;
        } catch (ReflectionException $e) {
            return false;
        }
    }

    /**
     * @param string $where
     * @param string $contentSlug
     * @return mixed
     */
    public function getContent(string $where, $contentSlug)
    {
        $result = $this->ModelCaller->ContentModel->where($where, $contentSlug)->find();
        return isset($result[0]) ? $result[0] : false;
    }

    /**
     * @param $param
     * @return mixed
     */
    public function searchContent($param)
    {
        $content = $this->ModelCaller->ContentModel
            ->like('title', $param, 'both')
            ->limit(5)
            ->getWhere()
            ->getResultArray();
        if ($content) {
            foreach ($content as $key => $value) {
                $user = $this->ModelCaller->UserModel->where('user_id', $content[$key]['user_id'])->find()[0];
                $content[$key]['title'] = html_entity_decode($content[$key]['title']);
                $content[$key]['user_name'] = $user['user_name'];
                $content[$key]['icon_name'] = $user['icon_name'];

            }
            return $content;
        } else {
            return false;
        }
    }

    /**
     * @param object $request
     * @param array $currentContent
     * @return array
     */
    public function updateContent(object $request, array $currentContent)
    {
        $data = [];
        $newData = [
            'content' => $request->getVar('contentHiddenForDiv'),
            'title' => $request->getVar('title'),
            'user_id' => session()->get('userInfo')['user_id']
        ];
        $imageLogic = new ImageLogic();
        $tempImageForSaving = $imageLogic->checkAndCopyImage();
        /*
         * is_local_image de kullanılacak lokasyonu belirlemek, sonraki kullanımlar için çok önemlidir,
         * anlık kullanılan kayıt lokasyonuna göre her ihtimale karşı tekrardan dinamik olarak belirlenir..
         *
         * */

        $newData['content_images'] = $this->lastContentImagesChecker(explode(',',$request->getVar('editorImagesHidden')),$newData['content']);
        $newData['is_local_image'] = $currentContent['is_local_image'] == getenv('UPLOAD_LOCATION') ? $currentContent['is_local_image'] : getenv('UPLOAD_LOCATION');
        $newData['title_image'] = !empty($tempImageForSaving['titleImageNameHere']) ? $tempImageForSaving['titleImageNameHere'] : $currentContent['title_image'];

        $data['result'] = $this->finishUpdate($currentContent, $newData);
        unset($imageLogic);
        return $data;

    }

    /**
     * @param $lastdata
     * @param $data
     * @return false
     */
    private function finishUpdate($lastdata, $data)
    {
        if (!empty($lastdata['user_id'])) {
            if ($lastdata['title'] != $data['title'] && empty($lastdata['old_title'])) {
                // Eğer başlık değişirse SEO yu etkilememesi için ve bir daha değişmemek üzere old_title başlığı
                // oluşturuluyor.. normalde old-title işlemlerde karşılaştırma için kullanılmaz
                // fakat sistemin gelişen ve ilerleyen dönemlerinde kararlılık için iyi bir imkan sunabilir..
                $data['old_title'] = $data['title'];
            }
            $lastdata['result'] = $this->ModelCaller->ContentModel
                ->where('slug', $lastdata['slug'])
                ->set($data)
                ->update();
            return $lastdata;
        } else {
            return false;
        }
    }


    /**
     * @param string $where
     * @param string $contentSlug
     * @return mixed
     */
    public function deleteContent(string $where, string $contentSlug)
    {
        $deleteForResult = $this->getContent($where, $contentSlug);
        if ((session()->get('userInfo')['role'] == 'admin') || (!empty($deleteForResult['user_id']) && $deleteForResult['user_id'] == session()->get('userInfo')['user_id'])) {
            $this->ModelCaller->ContentModel->where($where, $contentSlug)->delete();
            $this->ModelCaller->CommentModel->where('content_id', $deleteForResult['content_id'])->delete();
            $this->ModelCaller->NotificationModel
                ->where('notification_where', 'content_id')
                ->where('notification_where_id', $deleteForResult['content_id'])
                ->delete();
            $uploader = new Uploader();
            $uploader->deleteImage($deleteForResult['title_image']);
            if (!empty($deleteForResult['content_images'])){
                $images = explode(',',$deleteForResult['content_images']);
                foreach ($images as $value){
                    $uploader->deleteImage($value);
                }
            }
            // İçerikleri session vb.. tutmak istenildiğinde Organizer iyi bir işlev görebilir.
            // (new Organizer())->internalCall();
            unset($uploader);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $slug
     */
    public function publicContent(string $slug)
    {

    }

    // Receiving from https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string

    /**
     * @param $text
     * @return string|string[]
     */
    public function slugify($text)
    {
        // For turkish characters.. sometimes, healthy results cannot be obtained from iconv function due to different reasons. That's why we define Turkish characters manually.
        //
        $turkish = array("ş","Ş","ı","ü","Ü","ö","Ö","ç","Ç","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç","ü","Ü");
        $turkishToStandart = array("s","S","i","u","U","o","O","c","C","s","S","i","g","G","I","o","O","C","c","u","U");

        $text = str_replace($turkish,$turkishToStandart,$text);
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);


        // Receiving from WordPress
        $chars = array();
        // Assume ISO-8859-1 if not UTF-8.
        $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
            . "\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
            . "\xc3\xc4\xc5\xc7\xc8\xc9\xca"
            . "\xcb\xcc\xcd\xce\xcf\xd1\xd2"
            . "\xd3\xd4\xd5\xd6\xd8\xd9\xda"
            . "\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
            . "\xe4\xe5\xe7\xe8\xe9\xea\xeb"
            . "\xec\xed\xee\xef\xf1\xf2\xf3"
            . "\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
            . "\xfc\xfd\xff";

        $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

        $string = strtr($text, $chars['in'], $chars['out']);
        $double_chars = array();
        $double_chars['in'] = array("\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe");
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $text = str_replace($double_chars['in'], $double_chars['out'], $string);
        if (empty($text)) {
            return false;
        }

        return $text;
    }
}