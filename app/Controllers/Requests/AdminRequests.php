<?php


namespace App\Controllers\Requests;


use App\Controllers\BaseController;
use App\Controllers\Constant\Limits;
use App\Controllers\Dashboard\Content;
use App\Controllers\Email\SmtpEmail;
use App\Controllers\Organizer\EnvSetter;
use App\Controllers\User\User;
use App\Controllers\Validate\Validator;
use App\Models\CommentModel;
use App\Models\ContentModel;
use App\Models\IpTables;
use App\Models\UserModel;
use AwsS3;

class AdminRequests extends BaseController
{
    private $Limits;

    public $subValidator;

    public function __construct()
    {
        $this->Limits = new Limits();
    }

    private function locationTimerCreate()
    {
        $d = new \DateTime('now');
        // d = gün
        // h = saat
        // i = dakika
        // s = saniye
        return $d->format('Y-m-d h:i:s');
    }

    public function locationSuspend()
    {
        $EnvSetter = new EnvSetter();
        $filename = '.env';
        $data = ['location_wait' => 0];
        if ($this->request->getMethod() == 'post') {
            if ($this->request->getVar('locationwait') == 1) {
                // Kullanıcı arayüzünde oluşabilecek herhangibir aksilik durumunda 10 saniyelik zaman dilimini
                // sunucu tarafından kontrol etmek için şu anki zamanı env dosyasınada yazdırıyoruz.
                $data['location_wait'] = $this->locationTimerCreate();
                $EnvSetter->envWriter($filename, $EnvSetter->siteConfDetector($data));
            } else {
                $EnvSetter->envWriter($filename, $EnvSetter->siteConfDetector($data));
            }
        }
        unset($EnvSetter);
        return $this->response->setStatusCode(200)->setJson($data);
    }

    public function searchUser()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $userName = $this->request->getVar('searchuser');
            $userM = new User();
            return $this->response->setStatusCode(200)->setJson(['user' => $userM->searchUser($userName)]);
        }
    }

    public function searchContent()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $contentName = $this->request->getVar('searchcontent');
            $contentM = new Content();
            return $this->response->setStatusCode(200)->setJson(['content' => $contentM->searchContent($contentName)]);
        }
    }

    public function deleteContent()
    {
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $contentM = new Content();
            return $this->response->setStatusCode(200)->setJson(['content' =>
                $contentM->deleteContent('slug', $this->request->getVar('deleteContentWithSlug'))]);
        }
    }

    public function updateUser()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {

            $validatonLogic = $this->request->getPost();
            if (!empty($validatonLogic['user_password']) || !empty($validatonLogic['user_email'])) {
                $subValidator = new Validator();
                $validate = $subValidator->userUpdateValidatorForAdminPanel($validatonLogic);
                if (!$this->validate($validate['rules'], $validate['errors'])) {
                    $data['validation'] = $this->validator->listErrors();
                    return $this->response->setStatusCode(200)->setJson($data);
                }
            }

            $newData = [];
            foreach ($validatonLogic as $key => $value) {
                $newData[$key] = $value;
            }
            if (session()->get('userInfo')['role'] != 'admin') {
                if (count($newData) > 1) {
                    $userM = new User();
                    return $this->response->setStatusCode(200)->setJson(['updatedUser' => $userM->updateAccount($newData)]);
                } else {
                    return $this->response->setStatusCode(200)->setJson(['updatedUser' => lang('DF_Validation.errors.admin_control.panel.user_panel.noProcess')]);
                }
            } else {
                return $this->response->setStatusCode(200)->setJson(['updatedUser' => lang('DF_Validation.errors.admin_control.panel.user_panel.adminNotUpdateExternally')]);

            }


        }
    }

    public function usersReport()
    {
        if ($this->request->getMethod() == 'post') {
//            $data = $this->request->getPost();

            $data = [];
            $userModel = new UserModel();
            $users = $userModel
                ->orderBy('last_login_date', 'DESC')
                ->limit($this->Limits->reportLimit)
                ->getWhere()
                ->getResultArray();
            $contentModel = new ContentModel();
            $commentModel = new CommentModel();
            foreach ($users as $key => $value) {

                $userCommentResultl = $commentModel
                    ->where('user_id', $users[$key]['user_id'])
                    ->orderBy('user_id', 'DESC')
                    ->limit($this->Limits->reportLimit);
                $userContentResult = $contentModel
                    ->where('user_id', $users[$key]['user_id'])
                    ->orderBy('user_id', 'DESC')
                    ->limit($this->Limits->reportLimit);
                $data[] = [
                    'user_name' => $users[$key]['user_name'],
                    'last_login_date' => $users[$key]['last_login_date'],
                    'total_content' => $userContentResult->countAllResults(),
                    'total_comment' => $userCommentResultl->countAllResults(),
                    'register_date' => $users[$key]['created_at'],
                    'role' => $users[$key]['role'],
                ];

            }
//
//            // Sıralama
//            $totalContent = [];
//            $totalComment = [];
//            foreach ($data as $key => $value){
//                $totalContent[$key] = $value['total_content'];
//                $totalComment[$key] = $value['total_comment'];
//            }
//            // Burada verileri ilk önce toplam içerik sayısına daha sonra yorum sayısına göre sıralıyoruz..
//            array_multisort($totalContent,SORT_DESC,$totalComment,SORT_DESC,$data);
//            unset($totalContent);
//            unset($totalComment);
//
            $dataReady = [
                'draw' => 1,
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
                'data' => $data,

            ];
            return $this->response->setStatusCode(200)->setJSON($dataReady);

        }
    }

    public function generalUsersReport()
    {
        if (getenv('LOG_WITH_DB') === 'ON') {
            if ($this->request->getMethod() == 'post') {
                $ipTables = new IpTables();
                $generalInfo = $ipTables->select([
                        'ip_id',
                        'ip_address',
                        'user_name',
                        'end_point',
                        'created_at',
                        'cookie_consent']
                )->orderBy('created_at', 'DESC')
                    ->limit($this->Limits->reportLimit)
                    ->getWhere()
                    ->getResultArray();
                $dataReady = [
                    'draw' => 1,
                    'recordsTotal' => count($generalInfo),
                    'recordsFiltered' => count($generalInfo),
                    'data' => $generalInfo,

                ];
                return $this->response->setStatusCode(200)->setJSON($dataReady);
            }
        }
    }

    public function reActivation()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $userM = new User();
            $email = new SmtpEmail();
            $userName = $this->request->getVar('reActivationUser');
            $activationInfo = [
                'setTo' => $userM->getAccount($userName, 'getUserInfoByName')['user_email'],
                'setSubject' => lang('DF_Messages.messages.SMTP.userRequest.activationMailSubject', ['site_name' => getenv('SITE_NAME')]),
            ];
            // Eğer bir kullanıcıya tekrar aktivasyon gönderiliyorsa bu kullanıcının
            // askıya alınmış olma ihtimaline karşı suspended kolonunu 0 yapıyoruz ve normal hale getirmiş oluyoruz.
            // Bununla birlikte tekrar aktive olacağı için email_status kolonunuda 0 yapıyoruz.
            $newData = [
                'user_name' => $userName,
                'suspended' => 0,
                'email_status' => 0,
                'activation_code' => $email->sendMail($activationInfo)
            ];
            return $this->response->setStatusCode(200)->setJSON(['reActivation' => $userM->updateAccount($newData)]);
        }
    }

    public function testMail()
    {
        $data = [];
        helper(['form']);
        $data['setMessage'] = 'test';
        $data['setSubject'] = 'test';
        if ($this->request->getMethod() == 'post') {
            if (!empty($this->request->getVar('test_mail_input')) && !empty($this->request->getVar('mail_smtp_user'))) {
                $data['mail_smtp_user'] = $this->request->getVar('mail_smtp_user');
                $data['setTo'] = $this->request->getVar('test_mail_input');
            }else{
                return $this->response->setStatusCode(200)->setJSON(['status' => 'error']);
            }
            $testMail = (new SmtpEmail())->testMail($data);
            if ($testMail === true) {
                unset($testMail);
                $data = $this->request->getPost();
                $filename = '.env';
                $EnvSetter = new EnvSetter();
                $EnvSetter->envWriter($filename, $EnvSetter->siteConfDetector($data));
                return $this->response->setStatusCode(200)->setJSON(['status' => 'ok']);
            } else {
                unset($testMail);
                return $this->response->setStatusCode(200)->setJSON(['status' => 'error']);
            }

        }

    }

    public function testAws()
    {
        $awsInfos = $this->request->getPost();
        $awsS3 = new AwsS3();
        $awsInfos['aws_system'] = 'ON';
        $filename = '.env';
        $EnvSetter = new EnvSetter();
        $awsInfos['aws_remotepublicaddress'] = rtrim($awsInfos['aws_remotepublicaddress'],'/');
        $EnvSetter->envWriter($filename, $EnvSetter->siteConfDetector($awsInfos));
        $result = $awsS3->transferAssets($awsInfos);
        unset($awsS3);
        return $this->response->setStatusCode(200)->setJSON(['worked' => $result]);

    }

    public function setSiteConf()
    {
        $data = [];
        helper(['form']);
        $data = ['location_wait' => 0];
        $EnvSetter = new EnvSetter();


        if ($this->request->getMethod() == 'post') {
            $temp = $this->request->getPost();
            if (!empty($temp['aws_remotepublicaddress'])){
                $temp['aws_remotepublicaddress'] = rtrim($temp['aws_remotepublicaddress'],'/');
            }
            // location_wait lokasyon değişikliğini kullanıcılara bildirir
            $temp['location_wait'] = 0;
            $data['detectedKeyAndValue'] = $EnvSetter->siteConfDetector($temp);
        }
        $filename = '.env';
        $last = $EnvSetter->envWriter($filename, $data['detectedKeyAndValue']);
        unset($EnvSetter);
        return $last;

    }
}