<?php


namespace App\Controllers\Requests;

use App\Controllers\Email\SmtpEmail;
use App\Controllers\Session;
use App\Controllers\User\User;
use App\Controllers\Validate\Validator;
use App\Controllers\View\Viewer;
use CodeIgniter\Exceptions\PageNotFoundException;
use ReflectionException;

class UserRequest extends User
{
    public $dynamicViewer;

    public $subValidator;

    public $SessionController;

    public $ConstantInfo;

    public function __construct()
    {
        $this->dynamicViewer = new Viewer();
        $this->subValidator = new Validator();
        $this->SessionController = new Session();
        parent::__construct();
    }


    public function checkIfLogged($page, $redirectLocation, $sessionKey, $data = [])
    {
        // giriş ve kayıt sayfalarında sağ üstteki giriş butonunu silmek için
        // sessiona parametre gönderiliyor..
        if ($this->SessionController->getSession('userInfo')) {
            return redirect()->to($redirectLocation);
        } else {
            $this->SessionController->setSession($sessionKey, true);
            $this->dynamicViewer->{$page}($data);
            session()->destroy();
        }
    }


    /**
     * @return mixed
     */
    public function islogin()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $validate = $this->subValidator->loginValidator();
            if (!$this->validate($validate['rules'], $validate['errors'])) {
                $data['validation'] = $this->validator;
            } else {
                $data = $this->getAccount($this->request->getVar('user_email'), 'getUserInfoByEmail');
                // Eğer smtp kullanıcı maili tanımlı iken mail aktivasyonu yapılmışsa email_status 1 olması gerekmektedir
                // ve aşağıdaki şartı geçip işlemlerine devam edebilecektir.
                $isSMTPTrue = $this->smptChecker();
                if ($isSMTPTrue === true && $data['email_status'] == 1) {
                    $this->SessionController->setSession('userInfo', $this->userLoginSessionSecurity($data));
                    return redirect()->to('/dashboard');
                } else {
                    // Eğer üyelik aktivasyonu çalışmıyorsa ve daha önceden aktivasyon kodu almadıysa
                    // kullanıcıya yine izin verilir.
                    if ($this->mailOnOffComplex($isSMTPTrue, $data)) {
                        $this->SessionController->setSession('userInfo', $this->userLoginSessionSecurity($data));
                        return redirect()->to('/dashboard');
                    } else {
                        // Eğer $isSMTPTrue değişkeni true olup üye aktivasyo kodu tarihi geçmemişse kullanıcıya aktivasyon yapması için bilgi verilir
                        if ($this->link_expire_checker($data['created_at']) === true) {
                            session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.userNeededActivation'));
                            redirect()->to('/users/login');
                        } else {
                            // Eğer kullanıcı aktivasyonu tarihi geçmişse kullanıcı kaydı bulunur ve silinir.
                            // Kullanıcıya tekrar kayıt olması gerektiği bilgisi aktarılır.
                            $user = $this->getAccount($this->request->getVar('user_email'));
                            $this->removeAccount($user['user_id']);
                            session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.userLaterForActivation'));
                            redirect()->to('/users/register');
                        }
                    }
                }
            }
        }
        $this->checkIfLogged('login', 'dashboard', 'loginPage', $data);
    }

    /**
     * @return mixed
     */
    public function newPass()
    {
        if ($this->request->getMethod() == 'post') {
            $validate = $this->subValidator->newPassValidator();
            if (!$this->validate($validate['rules'], $validate['errors'])) {
                $data['validation'] = $this->validator;
                return $this->dynamicViewer->forgot($data);
            } else {
                if ($this->smptChecker() === true && getenv('MAIL_SYSTEM') == 'ON') {
                    $activationInfo = [
                        'setTo' => $this->request->getVar('user_email'),
                        'setSubject' => lang('DF_Messages.messages.SMTP.userRequest.newPassSubject', ['site_name' => getenv('SITE_NAME')]),
                    ];
                    $activationSender = new SmtpEmail();
                    // Şifre yenileme maili göndermede bir problem yaşanmadıysa bu koşul çalışacaktır.
                    if ($activationSender->activationBase !== false) {
                        try {
                            $userData = $this->getAccount($activationInfo['setTo'], 'getUserInfoByEmail');
                            $newData = [
                                'user_name' => $userData['user_name'],
                                'activation_code' => $activationSender->sendMail($activationInfo)
                            ];
                            $this->updateAccount($newData);
                            session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.newPass'));
                            return redirect()->to('/users/login');
                        } catch (ReflectionException $e) {
                            throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.newPassFail'));
                        }
                    } else {
                        throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.newPassFail'));
                    }
                } else {
                    try {
                        session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.newPassFail'));
                        return redirect()->to('/users/login');
                    } catch (ReflectionException $e) {
                        throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.newPassFail'));
                    }
                }

            }
        }
        unset($activationSender);
    }

    public function userActivation(string $activationCode)
    {
        if ($this->request->getMethod() == 'get') {
            $isActiovationOK = $this->getActivationUser($activationCode);
            if (!empty($isActiovationOK['user_name'])) {
                $a = new \DateTime('now');
                $newData = [
                    'user_name' => $isActiovationOK['user_name'],
                    // Aktive olmuş kullanıcıya son giriş tarihini ekliyoruz.
                    'last_login_date' => $a->format('Y-m-d h:i:s'),
                    'email_status' => 1,
                    // Aynı aktivasyon kodunun kullanılmaması için kod sütununu sıfırlıyoruz.
                    'activation_code' => NULL,
                ];
                $this->updateAccount($newData);
                $this->SessionController->setSession('userInfo', $this->userLoginSessionSecurity($isActiovationOK));
                if ($isActiovationOK['email_status'] == 1) {
                    session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.newPassReminder'));
                    return redirect()->to('/users/profile');
                }
                return redirect()->to('/dashboard');
            } else {
                throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.activationCodeRefused'));
            }
        }
    }

    public function register()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $validate = $this->subValidator->registerValidator();
            if (!$this->validate($validate['rules'], $validate['errors'])) {
                $data['validation'] = $this->validator;
//                print_r($data['validation']->listErrors());
                return $this->dynamicViewer->register($data);
            } else {
                if ($this->smptChecker() === true && getenv('MAIL_SYSTEM') == 'ON') {
                    $activationInfo = [
                        'setTo' => $this->request->getVar('user_email'),
                        'setSubject' => lang('DF_Messages.messages.SMTP.userRequest.activationMailSubject', ['site_name' => getenv('SITE_NAME')]),
                    ];
                    $activationSender = new SmtpEmail();

                    if ($activationSender->activationBase !== false) {
                        $isMailSuccessAngGettingActivationCode = $activationSender->sendMail($activationInfo);
                        if ($isMailSuccessAngGettingActivationCode !== false) {
                            try {
                                $this->setAccount($this->request, $isMailSuccessAngGettingActivationCode);
                                session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.afterRegisterForMailActivation'));
                                return redirect()->to('/users/login');
                            } catch (ReflectionException $e) {
                                throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.registerFail'));
                            }
                        } else {
                            throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.registerFail'));
                        }
                    } else {
                        throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.activationEndPointFail'));
                    }
                } else {
                    // Eğer aktivasyon sistemi tanımlanmadıysa veya aktif değilse sadece girişe yönlendirilecektir.
                    try {
                        $this->setAccount($this->request);
                        session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.succesWithoutActivation'));
                        return redirect()->to('/users/login');
                    } catch (ReflectionException $e) {
                        throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.registerFail'));
                    }
                }

            }
            unset($activationSender);
        }
        // giriş ve kayıt sayfalarında sağ üstteki giriş butonunu silmek için
        // sessiona parametre gönderiliyor..
        $this->checkIfLogged('register', 'dashboard', 'registerPage', $data);
    }

    public function profile()
    {
        $data = [];
        helper(['form']);
        if ($this->request->getMethod() == 'post') {
            $validate = $this->subValidator->profileUpdaterValidator();
            if (!$this->validate($validate['rules'], $validate['errors'])) {
                $data['validation'] = $this->validator;
                $data['user'] = $this->getAccount($this->SessionController->getSession('userInfo')['user_name'], 'getUserInfoByName');
                $this->dynamicViewer->profile($data);
            } else {
                $newData = [
                    'user_name' => session()->get('userInfo')['user_name'],
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                    'user_password' => $this->request->getPost('user_password')
                ];
                if ($this->updateAccount($newData)) {
                    session()->setFlashdata('success', lang('DF_Messages.messages.flashData.userRequest.successRecord'));
                    return redirect()->to('/users/profile');
                } else {
                    throw PageNotFoundException::forPageNotFound($message = lang('DF_Messages.messages.HTTP.userRequest.registerFail'));
                }
            }
        }
    }

    public function logout()
    {
        $this->SessionController->removeSession();
        return redirect()->to('/');
    }
}