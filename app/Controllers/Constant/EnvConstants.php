<?php


namespace App\Controllers\Constant;


class EnvConstants
{

    public $envConst;
    public function __construct()
    {
        $this->envConst = [
            'setup' => 'SETUP',
            'hostname' => 'database.default.hostname',
            'username' => 'database.default.username',
            'password' => 'database.default.password',
            'database' => 'database.default.database',
            'DBDriver' => 'database.default.DBDriver',
            'logger' => [
                'file' => 'LOG_WITH_FILE',
                'db' => 'LOG_WITH_DB',
            ],
            'mail_system' => 'MAIL_SYSTEM',
            'mail_config' => [
                'system' => [
                    'email_activation_endpoint' => 'EMAIL_ACTIVATION_ENDPOINT',
                    'mail_protocol' => 'MAIL_Protocol',
                    'mail_path' => 'MAIL_Path',
                    'mail_charset' => 'MAIL_Charset',
                    'mail_wordwrap' => 'MAIL_WordWrap',
                    'mail_priority' => 'MAIL_Priority',
                ],
                'host' => [
                    'mail_smtp_host' => 'MAIL_SMTPHOST',
                    'mail_smtp_user' => 'MAIL_SMTPUSER',
                    'mail_smtp_pass' => 'MAIL_SMTPPASS',
                    'mail_smtp_port' => 'MAIL_SMTPPORT',
                ],
                'activation_mail_content' => [
                    'mail_from' => 'MAIL_FROM',
                    'mail_name' => 'MAIL_NAME',
                    'mail_default_subject' => 'MAIL_DEFAULT_SUBJECT',
                    'mail_default_welcome' => 'MAIL_DEFAULT_MESSAGE_WELCOME',
                    'mail_default_link_text' => 'MAIL_DEFAULT_MESSAGE_LINK_TEXT',
                    'mail_default_alternative_text' => 'MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT',
                    'mail_default_alternative_text2' => 'MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT2',
                ],

            ],
            'aws_system' => 'AWS_ENABLED',
            'aws_config' => [
                'aws_region' => 'AWS_REGION',
                'aws_acceskeyid' => 'AWS_ACCESKEYID',
                'aws_secretkey' => 'AWS_SECRETKEY',
                'aws_bucketname' => 'AWS_BUCKET_NAME',
                'aws_remotepublicaddress' => 'REMOTE_PUBLIC_BASE_ADDRESS',
            ],
            'google_captcha' => [
                'captcha_secret_key' => 'captcha_secret_key',
                'capctcha_site_key' => 'capctcha_site_key',
            ],
            'site_general' => [
                'site_name' => 'SITE_NAME',
                'site_upload_location' => 'UPLOAD_LOCATION'
            ],
            'image_location' => [
                'image_folder_base' => 'IMAGE_FOLDER_BASE',
                'real_image_folder' => 'REAL_IMAGE_FOLDER',
                'icon_base_folder' => 'ICON_BASE_FOLDER',
            ],
            'app_baseURL' => 'app.baseURL',
            'location_wait'=> 'LOCATION_WAIT',
        ];
    }

    public function __deconstruct()
    {
        unset($this->envConst);
    }
}