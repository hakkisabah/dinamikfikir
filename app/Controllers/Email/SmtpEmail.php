<?php

namespace App\Controllers\Email;

use App\Controllers\Constant\ConstantInfo;

class SmtpEmail
{
    private $email;
    private $defaultMailInformation;
    private $ConstantInfo;
    public $activationBase;

    public function __construct($data = [])
    {
        $this->email = \Config\Services::email();
        $this->ConstantInfo = new ConstantInfo();
        $this->defaultMailInformation = $this->ConstantInfo->emailConst();
        $this->activationBase = $this->ConstantInfo->emailActiovationEndpoint();
    }

    private function activation_code_generator($email)
    {
        return sha1(mt_rand(10000, 99999) . time() . $email);
    }

    public function sendMail($data = [])
    {
        $data['mail_name'] = lang('View.setup.defaultMailEnv.MAIL_NAME');
        $data['mail_default_welcome'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_WELCOME');
        $data['mail_default_link_text'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_LINK_TEXT');
        $data['mail_default_alternative_text'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT');
        $data['mail_default_alternative_text2'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT2');

        if (!empty($data['setTo'])) {
            $data['activationCode'] = $this->activation_code_generator($data['setTo']);
            $data['setMessage'] = $data['mail_default_welcome'] . ' ' .
                anchor($this->activationBase . $data['activationCode'], $data['mail_default_link_text'] . ' ', '') . '<br><br>' .
                $data['mail_default_alternative_text'] . ' <strong>' . $this->activationBase . $data['activationCode'] . '</strong> ' . $data['mail_default_alternative_text2'];
            $activationMail = $this->mail_generator($data);
            if (!$activationMail->email->send()) {
                return false;
            } else {
                return $data['activationCode'];
            }
        }else{
            return false;
        }
    }

    public function testMail($data)
    {
        if (!empty($data['setTo'])) {
            $testMail = $this->mail_generator($data);
            if (! $testMail->email->send()) {
                return false;
            } else {
                return true;
            }
        }else{
            return false;
        }

    }

    private function mailFromLogic($data = [])
    {
        // Eğer kullanıcı mail göndericisini tanımlamamışsa
        // bu kullanıcı adıyla aynı olan mail adresi olarak tanımlanacaktır.
        if (!empty($data['mail_from'])){
            return $data['mail_from'];
        }elseif(!empty($this->defaultMailInformation['sendingInformation']['from'])){
            return $this->defaultMailInformation['sendingInformation']['from'];
        }else{
            return false;
        }
    }
    private function mail_generator($data)
    {
        // $data['mail_from'] geldiğinde kurulum aşamasından geldiği anlaşılır..
        if (!empty($data['mail_from'])){
            $this->defaultMailInformation['config']['SMTPHost'] = $data['mail_smtp_host'];
            $this->defaultMailInformation['config']['SMTPUser'] = $data['mail_smtp_user'];
            $this->defaultMailInformation['config']['SMTPPass'] = $data['mail_smtp_pass'];
            $this->defaultMailInformation['config']['SMTPPort'] = $data['mail_smtp_port'];
        }
        $this->email->initialize($this->defaultMailInformation['config']);
        $logicResult = $this->mailFromLogic(!empty($data)?$data:'');
        $this->email->setFrom($logicResult !== false?$logicResult:getenv('MAIL_SMTPUSER'), $data['mail_name']);
        $this->email->setMailType(getenv('MAIL_TYPE'));
        $this->email->setTo($data['setTo']);
        $this->email->setSubject($data['setSubject']);
        $this->email->setPriority(getenv('MAIL_Priority'));
        $this->email->setMessage($this->email_design($data['setMessage']));
        $sended = new \stdClass();
        $sended->email = $this->email;
        return $sended;
    }

    private function email_design($link)
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>'. getenv('SITE_NAME') . '</title>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}  
        </style>
    </head>
    <body yahoo bgcolor="#f6f8f1">
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>' .
                               $link
                           . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
    }

}