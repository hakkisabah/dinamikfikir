<?php


namespace App\Controllers\Requests;

use App\Controllers\BaseController;
use App\Controllers\ConstantBase;
use App\Controllers\Dashboard\Content;
use App\Controllers\Dashboard\ImageLogic;
use App\Controllers\Session;
use App\Controllers\Validate\Validator;
use App\Controllers\View\Viewer;
use CodeIgniter\Exceptions\PageNotFoundException;

class ContentRequest extends BaseController implements ContentRequests
{

    /**
     * @var Viewer
     */
    public $dynamicViewer;
    /**
     * @var Validator
     */
    public $subValidator;
    /**
     * @var ConstantBase
     */
    public $ConstantBase;
    /**
     * @var Content
     */
    protected $Content;
    /**
     * @var Session
     */
    private $SessionController;

    /**
     * ContentRequest constructor.
     */
    public function __construct()
    {
        $this->dynamicViewer = new Viewer();
        $this->subValidator = new Validator();
        $this->Content = new Content();
        $this->ConstantBase = new ConstantBase();
        $this->SessionController = new Session();
    }
    public function addcontent()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            // Yeni içerik kaydı oluşturulurken bir resim yüklenip yüklenmediğini geçici resim var mı yok mu diye sorgularız
            if (!$this->SessionController->getSession('titleImageNameHere')) {
                // Eğer hiç görsel yüklenmemişse hata mesajını tetikleyebilmek için
                // (new ImageRequest())->uploadImage methoduna true parametresini gönderiyoruz
                return (new ImageRequest())->uploadImage(true,$this);
            }
            $validate = $this->subValidator->contentValidator();
            if (!$this->validate($validate['rules'], $validate['errors'])) {
                $data['validation'] = $this->validator;
                if ($this->SessionController->getSession('titleImageNameHere')) {
                    // Başlık resmi yükleme zorunlu olduğu için validasyona yüklenmiş resmide atıyoruz.
                    $data['validation']->title_image = $this->ConstantBase->ConstantInfo->imageBase() . $this->SessionController->getSession('titleImageNameHere');
                    $data['currentBase'] = $this->ConstantBase->ConstantInfo->currentBase();
                    $this->dynamicViewer->dashEditor($data);
                } else {
                    // Güvenlik -
                    // Diğer kontrolleri aşıp metin kontrolünde de geçici bir görsel halen yüklenmemişse
                    // bu kullanıcının farklı niyet içerdiğini söyleyebiliriz. Bu yüzden sayfa görüntüleme işlemi hatası veriyoruz.
                    // Güvenlik -
                    throw PageNotFoundException::forPageNotFound();
                }
            } else {
                try {
                    $this->Content->setContent($this->request);
                    return redirect()->to('/dashboard');
                } catch (\ReflectionException $e) {
                    throw PageNotFoundException::forPageNotFound();
                }

            }
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }


    /**
     * @return \CodeIgniter\HTTP\RedirectResponse|void
     */
    public function updatecontent()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $currentContent = $this->Content
                ->getContent(
                    'content_id',
                    strip_tags($this->request->getVar('contentId'))
                );
            if (isset($currentContent)) {
                $validate = $this->subValidator->contentValidator();
                if (!$this->validate($validate['rules'], $validate['errors'])) {
                    $data['validation'] = $this->validator;
                    $tempImages = $this->ConstantBase->ConstantInfo->publicTitleImageAddress($currentContent);
                    $data['validation']->title_image = $tempImages['title'];
                    // Tekrar bir hata olması durumunda content_id ile daha stabil ve hızlı işlem yapılabilmesi için
                    // hata sayfasına ilgili id numarasını gönderiyoruz
                    $data['validation']->content_id = $currentContent['content_id'];
                    $data['currentBase'] = $this->ConstantBase->ConstantInfo->currentBase();
                    return $this->dynamicViewer->dashEditor($data);
                } else {
                    $imageLogic = new ImageLogic();
                    // Yeni içerikte Content.php içerisinde bulunan setContent methodunda içerik eklendikten sonra
                    // changeLocationIfDifferent() methodu kullanılıyor..
                    // Burada ise içerik güncellemeden önce kullanılıyor..
                    // Bunun en büyük sebebi eğer kullanıcı farklı lokasyondayken yükleme yapmışsa önceden yüklenen içerikleri
                    // değişen lokasyona geçirmektir..
                    $imageLogic->changeLocationIfDifferent($currentContent);
                    unset($imageLogic);
                    $updated = $this->Content->updateContent($this->request, $currentContent);
                    if ($updated['result']) {
                        return redirect()->to('/dashboard');
                    } else {
                        throw PageNotFoundException::forPageNotFound();
                    }
                }
            } else {
                throw PageNotFoundException::forPageNotFound();
            }
        }
    }

    /**
     * @param string $slug
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deletecontent(string $slug)
    {
        $deleteResult = $this->Content->deleteContent('slug', $slug);
        if ($deleteResult) {
            return redirect()->to('/dashboard/contents');
        } else {
            return redirect()->to('/');
        }
    }
}