<?php


namespace App\Controllers\Requests;


use App\Controllers\BaseController;
use App\Controllers\ConstantBase;
use App\Controllers\Organizer\ModelCaller;
use App\Controllers\SharedData\SharedData;
use App\Controllers\Validate\Validator;
use App\Controllers\View\Viewer;
use ReflectionException;

class CommentRequest extends BaseController implements Comments
{

    private $ModelCaller;

    public $subValidator;

    public $queryLimitsOrganizer;

    public $dynamicViewer;

    public function __construct()
    {
        $this->queryLimitsOrganizer = (new ConstantBase())->Limits;
        $this->dynamicViewer = new Viewer();
        $this->ModelCaller = new ModelCaller();
        $this->subValidator = new Validator();
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    public function setComment()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $contentId = $this->request->getVar('content_id');
            $validate = $this->subValidator->commentValidator();
            if (!$this->validate($validate['rules'], $validate['errors'])) {
                $data['validation'] = $this->validator;
                // Herhangibir hata durumunda yeni yorumlar gelmiş olabilir bunun için gerekli işlemler tekrarlarnır..
                return $this->endComment($this->request->getVar('contentslug'), $data['validation']);
            } else {
                $commetDataForSave = [
                    'content_id' => $contentId,
                    'comment' => htmlspecialchars(strip_tags($this->request->getVar('comment'))),
                    'user_id' => session()->get('userInfo')['user_id']
                ];
                // $this->ModelCaller->CommentModel->insert($commetDataForSave) komutu session değeri olarak id verecektir diğer türlü kullanımlar
                // NotificationSetter filtresinde problem çıkartabilir veya uyumsuz çalışabilir..
                $notificationId = $this->ModelCaller->CommentModel->insert($commetDataForSave);
                session()->set('tempNotificationId', $notificationId);
                return redirect()->to('/content/' . $this->request->getVar('contentslug') . '#dynamiccomments');
            }
        }
    }

    public function getUserByIdForUserName($id)
    {
        return $this->ModelCaller->UserModel->asObject()->where('user_id', $id)->find()[0]->user_name;
    }


    public function endComment($slug, $internalForComment = null)
    {
        if ($internalForComment != null) {
            $lastdata['public_content_data'] = (new SharedData())->getPublicContent('slug', $slug);
            $lastdata['validation'] = $internalForComment;
            $this->dynamicViewer->publicContent($lastdata);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }

    }

    /**
     * @param int $comment
     * @return mixed
     */
    public function getComments(int $comment)
    {
        // TODO: Implement getComments() method.
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteComment(int $id)
    {
        // Kullanıcıda farklı niyet var ise başımızdan defediyoruz.
        if (strip_tags($id) != $id){
            return redirect()->to('/');
        }
        // Sahiplik filtresinden geçen yorum silme işlemine ait id bilgisi ile ilgili yorum bulunur.
        $lastdata['result'] = $this->ModelCaller->CommentModel->where('comment_id', $id);
        $gettingdata = $lastdata['result']->getWhere();
        $lastdata['result'] = $gettingdata->getResult();
        if (isset($lastdata['result'][0]->user_id)) {
            // Bulunan yoruma ait içeriği doğrulamak için tekrardan bir sorgu yapılır..
            $lastdata['resultForContent'] = $this->ModelCaller->ContentModel
                ->where('content_id', $lastdata['result'][0]->content_id)
                ->find();
        }
        if (isset($lastdata['resultForContent'][0]['user_id'])) {
            // Eğer içerik var ise ilgili içeriğe ait silmek istenilen yorum için silme işlemi başlatılır..
            $this->ModelCaller->CommentModel->where('comment_id', $id)->delete();
            // Daha sonra ilgili içeriği yorum bölümüne yönlendirme yapılır.
            return redirect()->to('/content/' . $lastdata['resultForContent'][0]['slug'] . '#dynamiccomments');
        } else {
            // Eğer içerik yok ise veya anlık olarak silindiyse kullanıcı anasayfaya yönlendirilir..
            return redirect()->to('/');
        }
    }

    public function __destruct()
    {
        unset($this->ModelCaller);
    }

}