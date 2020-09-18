<?php

namespace App\Controllers\Constant;


use App\Controllers\Organizer\EnvSetter;
use App\Controllers\Session;
use CodeIgniter\Exceptions\PageNotFoundException;

class ConstantInfo
{

    public $imageFolderBase;
    public $remoteImageLinkBase;
    public $AwsS3BucketName;
    public $tempImageFolderBase;
    public $indexDataMinuteValue;
    public $minuteConst;
    public $timeValueForMinute;
    public $localImageLinkBase;


    public $localStateTemp;

    public $remoteStateTemp;

    public $localStateReal;

    public $remoteStateReal;

    public $iconState;


    private $SessionController;

    public $smtpChecker;

    public function __construct()
    {
        $this->smtpChecker = getenv('MAIL_SYSTEM') == 'ON' ? 'ON' : 'OFF';
        $this->SessionController = new Session();
        $this->minuteConst = MINUTE;
        $this->timeValueForMinute = 5;
        $this->indexDataMinuteValue = $this->minuteConst * $this->timeValueForMinute;
        $this->localImageLinkBase =  base_url() . '/';
        $this->remoteImageLinkBase = getenv('REMOTE_PUBLIC_BASE_ADDRESS') . '/';
        $this->imageFolderBase = getenv('IMAGE_FOLDER_BASE') . getenv('REAL_IMAGE_FOLDER');


        $this->AwsS3BucketName = getenv('AWS_BUCKET_NAME');


        $this->localStateReal = ROOTPATH . $this->imageFolderBase;

        $this->remoteStateReal = $this->imageFolderBase;

        $this->iconState = getenv('ICON_BASE_FOLDER');
    }

    public function emailConst()
    {
        return [
            'config' => [
                'protocol' => getenv('MAIL_Protocol'),
                'mailpath' => getenv('MAIL_Path'),
                'charset' => getenv('MAIL_Charset'),
                'wordWrap' => getenv('MAIL_WordWrap'),
                'priority' => getenv('MAIL_Priority'),
                'SMTPHost' => getenv('MAIL_SMTPHOST'),
                'SMTPUser' => getenv('MAIL_SMTPUSER'),
                'SMTPPass' => getenv('MAIL_SMTPPASS'),
                'SMTPPort' => getenv('MAIL_SMTPPORT'),
            ],
            'sendingInformation' => [
                'from' => getenv('MAIL_FROM'),
                'mail_name' => getenv('MAIL_NAME'),
                'default_subject' => getenv('MAIL_DEFAULT_SUBJECT'),
                'default_message' => getenv('MAIL_DEFAULT_MESSAGE'),
            ],
        ];
    }

    public function emailActiovationEndpoint()
    {
        return !empty(getenv('EMAIL_ACTIVATION_ENDPOINT')) ? base_url() . '/' . getenv('EMAIL_ACTIVATION_ENDPOINT') : false;
    }

    public function currentBase()
    {
        if (getenv('UPLOAD_LOCATION') != 'LOCAL') {
            return $this->remoteImageLinkBase;
        } else {
            return $this->localImageLinkBase;
        }
    }

    public function getIconState()
    {
        if (getenv('UPLOAD_LOCATION') != 'LOCAL') {
            return $this->remoteImageLinkBase . $this->iconState;
        } else {
            return $this->localImageLinkBase . $this->iconState;
        }
    }

    public function imageBase()
    {
        if (getenv('UPLOAD_LOCATION') != 'LOCAL') {
            return $this->remoteImageLinkBase . $this->imageFolderBase;
        } else {
            return $this->localImageLinkBase . $this->imageFolderBase;
        }
    }

    public function publicTitleImageAddress($queryresult)
    {
        // İlk olarak içerik oluşturmada zorunlu olan başlık görseli sorgulanır.
        if (isset($queryresult['title_image'])) {
//            $detectLocalForPubLicView['title'] =  $queryresult['is_local_image'] == 'LOCAL'
            $detectLocalForPubLicView['title'] = $queryresult['is_local_image'] === 'LOCAL'
                ?
                $this->localImageLinkBase . $this->imageFolderBase
                :
                $this->remoteImageLinkBase . $this->imageFolderBase;
            $detectLocalForPubLicView['title'] = $detectLocalForPubLicView['title'] . $queryresult['title_image'];
            return $detectLocalForPubLicView;
        } else {
            // Eğer bir içeriğin başlık görseli bulunmuyorsa bu görsel gösteriminde veya oluşturumunda bir problem olduğu anlaşılır.
            // ve ilk gösterimde olası problemleri azaltabilmek için varsayılan resim kullanılır.
            $detectLocalForPubLicView['title'] = $this->localImageLinkBase . $this->imageFolderBase . 'dinamikfikirDefaultTitleImage.png';
            return $detectLocalForPubLicView;
        }
    }

}