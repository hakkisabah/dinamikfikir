<?php


namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Controllers\Constant\ConstantInfo;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserLogic extends BaseController
{

    public $ConstantInfo;

    public function __construct()
    {
        $this->ConstantInfo = new ConstantInfo();
    }

    protected function userLoginSessionSecurity($data)
    {
        unset($data['user_password']);
        return $data;
    }

    protected function mailOnOffComplex($isSMTPTrue, $data)
    {
        if ($data['role'] != 'admin') {
            if (
                ($isSMTPTrue === false && $data['activation_code'] && $data['email_status'] == 1)
                ||
                ($isSMTPTrue === false && empty($data['activation_code']) && $data['email_status'] == 0)
                ||
                ($isSMTPTrue === true && empty($data['activation_code']) && $data['email_status'] == 0)
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }

    }

    protected function smptChecker()
    {
        // Eğer smtp tanımlanmışsa kayıt olan kullanıcılar için aktivasyon işlemi sorgulanır
        // ve smtp kullanıcısı boşsa bu değer false döner
        if (!empty(getenv('MAIL_SMTPHOST'))
            &&
            !empty(getenv('MAIL_SMTPUSER'))
            &&
            !empty(getenv('MAIL_SMTPPASS'))
            &&
            !empty(getenv('MAIL_SMTPPORT'))
            &&
            !empty(getenv('MAIL_FROM'))
        ) {
            return true;
        }else{
            return false;
        }


    }

    protected function link_expire_checker($date)
    {
        try {
            $past = new \DateTime($date);
            $now = new \DateTime();
            $result = explode(",", $past->diff($now)->format("%d,%h"));
            // $result[0] günü ifade ederken $result[1] saati ifade etmektedir.
            // bu bilgilere göre eğer 48 saat yani 2 gündür kullanılmayan bir link mevcut ise
            // bu tespit edilir ve false döner.
            if ($result[0] > 2 && $result[1] > 0) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            echo view('errors/html/error_404',['message' => lang('DF_Messages.messages.HTTP.userLogic.serverProblem')]);
        }

    }
}