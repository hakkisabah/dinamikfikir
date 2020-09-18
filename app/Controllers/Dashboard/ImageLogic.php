<?php


namespace App\Controllers\Dashboard;

use App\Controllers\Extension\Uploader;
use App\Controllers\Session;

class ImageLogic
{

    public $SessionController;

    public function __construct()
    {
        $this->SessionController = new Session();
    }

    public function removeSingleTemp($name)
    {

        return (new Uploader())->deleteImage($name);
    }

    public function imageRequestDetector($request)
    {
        if (empty($request->getFiles())) {
            return false;
        }
        // Görsel içerik olarak hangi bölümden istek geldiği tespit edilir.
        $isFileWhich = array_keys($request->getFiles())[0] === 'editorImage' ? 'editorImage' : 'titleImage';
        $isFile = $request->getFiles()[$isFileWhich]->isFile();
        if ($isFile != false) {
            return $isFileWhich;
        } else {
            return false;
        }
    }

    /**
     * @param object $request
     * @param string $whichRequest
     * @return array
     */
    public function createImage(object $request,string $whichRequest)
    {
        $tempForContentObjects = [];

        $Uploader = new Uploader();
        // Hangi görsel olursa olsun bunu ilk olarak yükleyip ismini alıyoruz.
        $whichImageNameHere = $Uploader->uploadImage($request->getFile($whichRequest));
        unset($Uploader);
        // Eğer başlık görseli yükleniyorsa buada tespit edilir ve tek bir resim olacağı için
        // detaylı işlem gerektirmez.
        if ($whichRequest == 'titleImage') {
            $tempForContentObjects['title'] = $whichImageNameHere;
            $this->SessionController->setSession('titleImageNameHere', $whichImageNameHere);
        }
        // Editörde yüklenecek resimlerin tespiti ve bu resimlerinde işlem anında silinip silinmediğini
        // kullanıcıya ait session da bir dizi olarak tutuyoruz.
        if ($whichRequest == 'editorImage') {
            $tempIsArray = $this->SessionController->getSession('editorImageNamesHere');
            if (isset($tempIsArray) && is_array($tempIsArray)) {
                $tempForContentObjects['editor'] = $tempIsArray;
                array_push($tempForContentObjects['editor'], $whichImageNameHere);
                $this->SessionController->setSession('editorImageNamesHere', $tempForContentObjects['editor']);
            } else {
                $tempForContentObjects['editor'] = array($whichImageNameHere);
                $this->SessionController->setSession('editorImageNamesHere', $tempForContentObjects['editor']);
            }

        }
        return $tempForContentObjects;
    }

    // Burası sessionda oluşturulmuş iki görsel dizisini tek bir diziye toplar.
    public function groupingImage()
    {
        // Burada işlemleri biraz daha basitleştirmek için ilk olarak
        // geçici başlık resmini silme işlemine yardım edecek dizinin içine atıyoruz
        $tempImageForSaving['titleImageNameHere'] = $this->SessionController->getSession('titleImageNameHere');
        $tempImageForSaving['editorImageNamesHere'] = $this->SessionController->getSession('editorImageNamesHere');

        return $tempImageForSaving;
    }

    public function checkAndCopyImage()
    {
        $tempImageForSaving = $this->groupingImage();

        $this->SessionController->removeSession('titleImageNameHere');
        $this->SessionController->removeSession('editorImageNamesHere');

        return $tempImageForSaving;
    }

    public function changeLocationIfDifferent(array $data)
    {
        $names = [];
        // Görsel dosyaların hedefi değiştiğini bu şarta göre belirliyoruz.
        if ($data['is_local_image'] != getenv('UPLOAD_LOCATION')) {
            if ($data['title_image']) {
                $names['title'] = $data['title_image'];
            }
            if ($data['content_images']) {
                $names['editor'] = explode(',', $data['content_images']);
            }
            $Uploader = new Uploader();
            $Uploader->changeLocation($names);
            unset($Uploader);
        }

    }

    // Sessionda tutulan tüm resimleri fiziksel ortamdan silen method..
    public function removeTempImagesLogic()
    {
        $deletingAllTemp = $this->groupingImage();
        if (!empty($deletingAllTemp)) {
            $Uploader = new Uploader();
            foreach ($deletingAllTemp as $key => $value) {
                if (isset($deletingAllTemp[$key])) {
                    if (is_array($value)) {
                        foreach ($value as $subValue) {
                            if (isset($subValue)) {
                                $Uploader->deleteImage($subValue);
                            }
                        }
                    } else {
                        if (isset($value)) {
                            $Uploader->deleteImage($value);
                        }
                    }
                }


            }
            unset($Uploader);
            session()->remove('titleImageNameHere');
            session()->remove('editorImageNamesHere');
        }
    }

    public function __destruct()
    {
        unset($this->SessionController);
    }

}