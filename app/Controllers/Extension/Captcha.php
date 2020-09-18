<?php


namespace App\Controllers\Extension;


class Captcha
{

    /**
     * @var string
     */
    protected $secretKey;
    public $responseCaptchaElementName;
    /**
     * @var mixed
     */
    public $remoteip;

    public function __construct()
    {
        $this->remoteip = $_SERVER["REMOTE_ADDR"];
        $this->responseCaptchaElementName = "g-recaptcha-response";
        $this->secretKey = getenv('captcha_secret_key');
    }
    public function getVerify($response)
    {
        if (!empty($this->secretKey)){
            $captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$this->secretKey&response=$response&remoteip=$this->remoteip");
            $result = json_decode($captcha);
            if ($result->success == 1) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }

    }
}