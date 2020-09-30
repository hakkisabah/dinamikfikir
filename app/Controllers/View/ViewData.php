<?php


namespace App\Controllers\View;


use App\Controllers\Organizer\Organizer;
use App\Controllers\SharedData\SharedData;

class ViewData extends ViewCreator
{

    public function __construct()
    {
        parent::__construct();
    }

    public function header_data($headerData = [])
    {
        $data['header_metas'] = [
            [
                ['name' => 'Content-type', 'content' => 'text/html; charset=utf-8'],
                ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'],
                ['name' => 'description', 'content' => $headerData ? $headerData['description'] : getenv('SITE_NAME')],
                ['name' => 'classification', 'content' => 'Personel , Blog'],
                ['name' => 'rating', 'content' => 'All'],
                ['name' => 'language', 'content' => 'Turkish,English'],
                ['name' => 'owner', 'content' => $headerData['content_owner_full_name'] ?? 'Hakkı SABAH'],
                ['name' => 'creator', 'content' => $headerData['content_owner'] ?? 'hakkisabah@hotmail.com'],
                ['name' => 'generator', 'content' => $headerData['content_owner'] ?? 'hakkisabah@hotmail.com'],
                ['name' => 'distribution', 'content' => 'global'],
            ],
            //Social Media
            [
                // Facebook or other
                ['property' => 'og:type', 'content' => 'blog'],
                ['property' => 'og:title', 'content' => $headerData['content_title'] ?? lang('View.header.index.head_metas.default_content_title')],
                ['property' => 'og:description', 'content' => $headerData['description'] ?? lang('View.header.index.head_metas.default_content_description')],
                ['property' => 'og:url', 'content' => current_url(true)],
                ['property' => 'og:site_name', 'content' => getenv('SITE_NAME')],
                ['property' => 'og:image', 'content' => !empty($headerData['content_title_image']) ? $this->currentBase . $this->imagePath . $headerData['content_title_image'] : $this->currentBase . 'public/assets/logo/logo.png'],
            ],
            [
                // Twitter
                ['name' => 'twitter:card', 'content' => 'summary_large_image'],
                ['name' => 'twitter:title', 'content' => $headerData['content_title'] ?? lang('View.header.index.head_metas.default_content_title')],
                ['name' => 'twitter:description', 'content' => $headerData['description'] ?? lang('View.header.index.head_metas.default_content_description')],
                ['name' => 'twitter:site', 'content' => '@dinamikfikir'],
                ['name' => 'twitter:image', 'content' => !empty($headerData['content_title_image']) ? $this->currentBase . $this->imagePath . $headerData['content_title_image'] : $this->currentBase . 'public/assets/logo/logo.png'],
            ],
        ];
        $data['linksTag'] = [
            [
                'rel' => 'stylesheet',
                'href' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css',
//                'integrity' => 'sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk',
//                'crossorigin' => 'anonymous',
            ],
            [
                'rel' => 'stylesheet',
                'href' => $this->currentBase . 'public/assets/css/specific/image-card.css',
            ],
            [
                'rel' => 'stylesheet',
                'href' => $this->currentBase . 'public/assets/css/specific/image-card.css',
            ],
            [
                'rel' => 'stylesheet',
                'href' => 'https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css',
            ],
            [
                'rel' => 'stylesheet',
                'href' => $this->currentBase . 'public/assets/css/specific/album.css',
            ],
            [
                'rel' => 'stylesheet',
                'href' => $this->currentBase . 'public/assets/css/specific/spinner-and-upload-button.css',
            ],
            [
                'rel' => 'apple-touch-icon',
                'href' => $this->currentBase . 'public/assets/logo/favicon.png',
                'sizes' => '180x180',
            ],
            [
                'rel' => 'icon',
                'href' => $this->currentBase . 'public/assets/logo/favicon.png',
                'sizes' => '32x32',
                'type' => 'image/png',
            ],
            [
                'rel' => 'icon',
                'href' => $this->currentBase . 'public/assets/logo/favicon.png',
                'sizes' => '16x16',
                'type' => 'image/png',
            ],
            [
                'rel' => 'manifest',
                'href' => $this->currentBase . 'public/assets/favicons/manifest.json',
            ],
            [
                'rel' => 'mask-icon',
                'href' => $this->currentBase . 'public/assets/logo/favicon.png',
                'color' => '#563d7c',
            ],
            [
                'rel' => 'canonical',
                'href' => base_url(),
            ],
        ];

        $data['titleInfo'] = $headerData['titleInfo'] ?? getenv('SITE_NAME');

        return $this->header($data);
    }

    public function admin_site_data()
    {
        return [
            'cssTarget' => $this->currentBase . 'public/assets/css/specific/switch-toggle.css',
            'logger' => [
                'file' => getenv('LOG_WITH_FILE'),
                'db' => getenv('LOG_WITH_DB'),
            ],
            'mail_system' => getenv('MAIL_SYSTEM'),
            'mail_config' => [
                'user' => [
                    'mail_smtp_host' => getenv('MAIL_SMTPHOST'),
                    'mail_smtp_user' => getenv('MAIL_SMTPUSER'),
                    'mail_smtp_pass' => getenv('MAIL_SMTPPASS'),
                    'mail_smtp_port' => getenv('MAIL_SMTPPORT'),
                ],
                'system' => [
                    'email_activation_endpoint' => getenv('EMAIL_ACTIVATION_ENDPOINT'),
                    'mail_protocol' => getenv('MAIL_Protocol'),
                    'mail_path' => getenv('MAIL_Path'),
                    'mail_charset' => getenv('MAIL_Charset'),
                    'mail_wordwrap' => getenv('MAIL_WordWrap'),
                    'mail_priority' => getenv('MAIL_Priority'),
                ],
                'activation_mail_content' => [
                    'mail_from' => getenv('MAIL_FROM') ?? getenv('MAIL_SMTPUSER'),
                    'mail_name' => getenv('MAIL_NAME'),
                    'mail_default_subject' => getenv('MAIL_DEFAULT_SUBJECT'),
                    'mail_default_welcome' => getenv('MAIL_DEFAULT_MESSAGE_WELCOME'),
                    'mail_default_link_text' => getenv('MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT'),
                    'mail_default_alternative_text' => getenv('MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT'),
                    'mail_default_alternative_text2' => getenv('MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT2'),
                ],

            ],
            'aws_system' => getenv('AWS_ENABLED'),
            'aws_config' => [
                'aws_region' => getenv('AWS_REGION'),
                'aws_acceskeyid' => getenv('AWS_ACCESKEYID'),
                'aws_secretkey' => getenv('AWS_SECRETKEY'),
                'aws_bucketname' => getenv('AWS_BUCKET_NAME'),
                'aws_remotepublicaddress' => getenv('REMOTE_PUBLIC_BASE_ADDRESS'),
            ],
            'google_captcha' => [
                'captcha_secret_key' => getenv('captcha_secret_key'),
                'capctcha_site_key' => getenv('capctcha_site_key'),
            ],
            'site_general' => [
                'site_name' => getenv('SITE_NAME'),
                'site_upload_location' => getenv('UPLOAD_LOCATION')
            ],
            'image_location' => [
                'image_folder_base' => getenv('IMAGE_FOLDER_BASE'),
                'real_image_folder' => getenv('REAL_IMAGE_FOLDER'),
                'icon_base_folder' => getenv('ICON_BASE_FOLDER'),
            ],

        ];
    }

    public function admin_users_data()
    {
        return [
            'cssTarget' => $this->currentBase . 'public/assets/css/specific/switch-toggle.css',
        ];
    }
    public function admin_contents_data()
    {
        return [
            'currentBase' => $this->currentBase,
        ];
    }

    public function nav_data($navData = [])
    {
        $navData['whichPage'] = $this->SessionController->getSession('loginPage') || $this->SessionController->getSession('registerPage');
        $navData['userInfo'] = $this->SessionController->getSession('userInfo');
        return $this->nav($navData);
    }

    public function card_data($anyData = [], $internal = false)
    {
        $data = [];
        $SharedData = new SharedData();
        $Organizer = new Organizer();
        $data['indexData'] = $SharedData->getIndexData()['result'];  //$this->SessionController->getSession('indexData'); // if you use the session index system , make sure your server is running stable. And don't forget uncomment from Filters.php and Routes.php
        // sayfa dashboard ta değilse bu data internalCall tarafından false döndürülecektir.
        // ve ViewLogic sınıfında bulunan cardLogic methodu bu mantığa göre hareket etmektedir..
        $data['userData'] = $Organizer->internalCall(); //$this->SessionController->getSession('userData');
        unset($SharedData);
        unset($Organizer);
        $data['loggedUserInfo'] = $this->SessionController->getSession('userInfo');
        if (!empty($anyData['userInfo'])) {
            // ContentData dizisi direk veritabanında geleceği için kullanıcı girişi yapmayan
            // misafir kullanıcılara yönelik bilgileri rahat bir şekilde sunabilecektir..
            $data['contentData'] = $anyData['contentData'];
            // Şarta bağlı olara userInfo bilgisini tekrardan misafir kullanıcılar için yeniliyoruz.
            $data['userInfo'] = $anyData['userInfo'];
            unset($anyData['userInfo']);
        }
        if ($internal) {
            return $data;
        } else {
            return $this->card_looper($data);

        }
    }

    public function dasboard_contents_data()
    {
        $data = $this->card_data([], true);
        return $this->dasboard_contents_looper($data);

    }

    public function public_content_data($anyData = [])
    {
        if (!empty($anyData)) {
            return $this->public_content_looper($anyData);
        }else{
            throw PageNotFoundException::forPageNotFound($messaga = 'Not Find');
        }

    }

    public function logoSubline()
    {
        $data['currentBase'] = $this->currentBase;
        $data['SITE_NAME'] = getenv('SITE_NAME');
        $data['slogan'] =  lang('View.header.index.head_metas.default_slogan');
        return $data;
    }

    public function profile_avatar_data()
    {
        $data = [];
        $Icons = (new \App\Controllers\Extension\Icons());
        $iconNames = explode(',', $Icons->Icons);
        $counter = 1;
        $data['avatars'] = '';
        foreach ($iconNames as $value) {
            if ($counter % 3 == 1) {
                $data['avatars'] .= '<div class="row">';
            }
            $selectiveImg = "selectAvatar('" . $value . "',this)";
            $avatarEqualsForSelected = $this->SessionController->getSession('userInfo')['icon_name'] == $value ? 'selected-avatar' : '';
            $data['avatars'] .= '<div onclick="' . $selectiveImg . '" class="col-md-4 list-group-item-action rounded ' . $avatarEqualsForSelected . '" style="border: #1b1b1b inset 1px;">
                        <div class="media table-hover">
                            <img src="' . $Icons->IconBaseAddress . $value . '"
                                 class="mr-3 mt-2" alt="' . substr($value, 0, -4) . '" 
                                 data-toggle="tooltip" data-placement="top" 
                                 title="' . substr($value, 0, -4) . '">
                        </div>
                    </div>';

            if ($counter % 3 == 0) {
                $data['avatars'] .= '</div>';
            }
            $counter++;
        }
        if ($counter % 3 != 1) $data['avatars'] .= '</div>';
        return $data;
    }

    public function profile_data($anyData = [])
    {
        $data = [];
    }

    public function login_data()
    {
        $data = [];
        $attributes = ['class' => 'form-signin'];
        $data['form_open'] = form_open('/users/islogin', $attributes);
        $data['loginLogoLink'] = $this->currentBase . 'public/assets/logo/logo.png';
        $data['inputAndLabel'] = [
            [
                form_label(lang('View.login.index.mailPlaceHolder'), 'user_email', ['class' => 'sr-only']),
                form_input([
                    'type' => "email",
                    'name' => "user_email",
                    'id' => "inputEmail",
                    'class' => "form-control",
                    'placeholder' => lang('View.login.index.mailPlaceHolder'),
                    'value' => set_value('user_email'),
                ], '', 'required autofocus')

            ],
            [
                form_label(lang('View.login.index.passPlaceHolder'), 'user_password', ['class' => 'sr-only']),
                form_input([
                    'type' => "password",
                    'name' => "user_password",
                    'id' => "inputPassword",
                    'class' => "form-control",
                    'placeholder' => lang('View.login.index.passPlaceHolder'),
                ], '', 'required')

            ],

        ];
        $data['form_close'] = form_close();
        return $this->login_form_looper($data);
    }

    public function register_data()
    {
        $data = [];
        $attributes = ['class' => 'form-signin'];
        $data['form_open'] = form_open('/users/register', $attributes);
        $data['inputAndLabel'] = [
            'user_name' => [
                form_label(lang('View.register.index.userNamePlaceHolder'), 'username'),
                form_input([
                    'type' => "text",
                    'name' => "user_name",
                    'id' => "inputEmail",
                    'class' => "form-control",
                    'placeholder' => lang('View.register.index.userNamePlaceHolder'),
                    'value' => set_value('user_name'),
                ])

            ],
            'firstname' => [
                form_label(lang('View.register.index.firstNamePlaceHolder'), 'firstname'),
                form_input([
                    'type' => "text",
                    'name' => "firstname",
                    'id' => "firstname",
                    'class' => "form-control",
                    'placeholder' => lang('View.register.index.firstNamePlaceHolder'),
                    'value' => set_value('firstname'),
                ])

            ],
            'lastname' => [
                form_label(lang('View.register.index.lastNamePlaceHolder'), 'lastname'),
                form_input([
                    'type' => "text",
                    'name' => "lastname",
                    'id' => "lastname",
                    'class' => "form-control",
                    'placeholder' => lang('View.register.index.lastNamePlaceHolder'),
                    'value' => set_value('lastname'),
                ])

            ],
            'user_email' => [
                form_label(lang('View.register.index.mailAddress'), 'user_email'),
                form_input([
                    'type' => "email",
                    'name' => "user_email",
                    'id' => "email",
                    'class' => "form-control",
                    'placeholder' => lang('View.register.index.mailAddress'),
                    'value' => set_value('user_email'),
                ])

            ],
            'user_password' => [
                form_label(lang('View.register.index.pass'), 'user_password'),
                form_input([
                    'type' => "password",
                    'name' => "user_password",
                    'id' => "password",
                    'class' => "form-control",
                    'placeholder' => lang('View.register.index.pass'),
                    'value' => "",
                ])

            ],
            'user_password_confirm' => [
                form_label(lang('View.register.index.passConfrim'), 'user_password_confirm'),
                form_input([
                    'type' => "password",
                    'name' => "user_password_confirm",
                    'id' => "password_confirm",
                    'class' => "form-control",
                    'placeholder' => lang('View.register.index.passConfrim'),
                    'value' => "",
                ])

            ],

        ];
        $data['form_close'] = form_close();
        return $this->register_form_looper($data);
    }

    public function footer_data($footerData = [])
    {
        $uri = service('uri');
        $data['script_tag'] = [
            'https://code.jquery.com/jquery-3.5.1.min.js',
            $this->currentBase . 'public/assets/js/ajax/axios_dist_axios.js',
            'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',
            'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js',
        ];
        $data['uri'] = $uri->getSegments();
        unset($uri);
        return $this->footer($data);
    }
}