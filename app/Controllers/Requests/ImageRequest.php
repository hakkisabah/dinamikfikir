<?php


namespace App\Controllers\Requests;

use App\Controllers\BaseController;
use App\Controllers\ConstantBase;
use App\Controllers\Dashboard\ImageLogic;
use App\Controllers\Extension\Uploader;
use App\Controllers\Session;
use App\Controllers\Validate\Validator;

class ImageRequest extends BaseController
{
    /**
     * @var Validator
     */
    public $subValidator;

    public $ConstantBase;
    public $SessionController;

    public function __construct()
    {
        $this->subValidator = new Validator();
        $this->ConstantBase = new ConstantBase();
        $this->SessionController = new Session();
    }

    public function uploadImage($internal = false,$contentRequestThis = false)
    {
        $data = [];
        helper(['form']);
        $ImageLogic = new ImageLogic();
        $Uploader = new Uploader();
        $whichRequest = $internal !== true ? $ImageLogic->imageRequestDetector($this->request):false;
        if ($whichRequest == 'titleImage') {
            $tempImageForDeleting = $this->SessionController->getSession('titleImageNameHere');
            if (isset($tempImageForDeleting)) {
                // Kayıt etme haricinde her seferinde gelebilecek birden fazla resim yükleme isteğini her zaman en son yüklenen ile işlem
                // yapabilmek amacıyla bir önceki resim silinir.
                $Uploader->deleteImage($tempImageForDeleting);
                unset($Uploader);
                unset($ImageLogic);
            }
        }

        // İstek ister fonksiyondan ister dışardaki kullanıcıdan gelsin
        // eğer istekte bir dosya yoksa  işlem alınmaz.
        $validateForImage = $whichRequest == 'titleImage' ? $this->subValidator->titleImageValidator() : $this->subValidator->contentImageValidator();
        if ($whichRequest != false) {
            if (!$this->validate($validateForImage['rules'], $validateForImage['errors'])) {
                return $this->response->setStatusCode(200)->setJSON(
                    ['tempImageError' =>
                        lang('DF_Messages.HTTP.imageRequest.tempImageErrorIsValid')
                    ]);
            } else {
                $ImageLogic = new ImageLogic();
                $returnForCurrentResponse = $ImageLogic->createImage($this->request,$whichRequest);
                $returnForCurrentResponse['baseLink'] = $this->ConstantBase->ConstantInfo->imageBase();
                unset($ImageLogic);
                return $this->response->setStatusCode(200)->setJSON(
                    ['imageLink' =>
                    // $imageLogic->createImage methodunda $whichRequest
                    // isimli session değişkenine kayıt edilen resim adını alıyoruz
                        $returnForCurrentResponse
                    ]);
            }
        } else {
            if ($internal) { // Burası ContantRequest dosyasındaki addcontent methodundan tetiklenir..
                $validateForImage = $this->subValidator->titleImageValidator();
                if (!$contentRequestThis->validate($validateForImage['rules'], $validateForImage['errors'])) {
                    $data['validation'] = $contentRequestThis->validator;
                    $data['currentBase'] = $contentRequestThis->ConstantBase->ConstantInfo->currentBase();
                    return $contentRequestThis->dynamicViewer->dashEditor($data);
                }
            } else {
                return $this->response->setStatusCode(200)->setJSON(
                    ['tempImageError' =>
                        lang('DF_Messages.HTTP.imageRequest.tempImageErrorIsValid')
                    ]);
            }
        }
    }

    // Editörde herhangi bir görsel silindiğinde bu method fiziksel silme işlemini gerçekleştirir
    public function removeSingleTempImage()
    {
        if ($this->request->getMethod() == 'post') {
            $imageName = $this->request->getVar('removeSingleTemp');
            if (!empty($imageName)) {
                $ImageLogic = new ImageLogic();
                $hasEditorTempImage = $ImageLogic->groupingImage();
                if (!empty($hasEditorTempImage['editorImageNamesHere'])) {
                    $findedKey = array_search($imageName, $hasEditorTempImage['editorImageNamesHere']);
                    if ($findedKey !== false) {
                        unset($hasEditorTempImage['editorImageNamesHere'][$findedKey]);
                        $editorImages = $hasEditorTempImage['editorImageNamesHere'];
                        if (is_array($editorImages)) {
                            session()->set('editorImageNamesHere', $editorImages);
                        } else {
                            session()->remove('editorImageNamesHere');
                        }
                        $result = $ImageLogic->removeSingleTemp($imageName);
                        unset($ImageLogic);
                        return $this->response->setStatusCode(200)->setJSON(
                            ['removedSingleTemp' =>
                                $result
                            ]);
                    }
                }
            } else {
                return $this->response->setStatusCode(200)->setJSON(
                    ['tempImageError' =>
                        'What do you want ?'
                    ]);
            }
        }
    }

    // Kullanıcı editör den herhangi bir sebepten dolayı işlemi yarıda bırakıp ayrılırsa bu javascript yardımıyla
    // tespit edilip bu methoda istek gönderilir..
    public function removeTempImages()
    {
        (new ImageLogic())->removeTempImagesLogic();
    }
}