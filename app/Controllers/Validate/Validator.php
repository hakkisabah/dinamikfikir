<?php


namespace App\Controllers\Validate;

use App\Controllers\ConstantBase;
use App\Controllers\Extension\Captcha;

class Validator
{
    public $limits;

    public function __construct()
    {
        $this->limits = (new ConstantBase())->Limits;
    }

    public function titleImageValidator()
    {
        $data = [];
        $data['rules'] = [
            'titleImage' => 'ext_in[titleImage,jpg,jpeg,png]|max_size[titleImage,1024]|uploaded[titleImage]',
        ];
        $data['errors'] = [
            'titleImage' => [
                'max_size' => lang('DF_Validation.errors.max_size', ['imageSize' => '1mb']),
                'ext_in' => lang('DF_Validation.errors.ext_in', ['imageExtensions' => 'jpg,jpeg,png']),
                'uploaded' => lang('DF_Validation.errors.uploaded',['whichOne' =>lang('DF_Validation.errors.titleImage')]),
            ],
        ];
        return $data;
    }

    public function contentImageValidator()
    {
        $data = [];
        $data['rules'] = [
            'editorImage' => 'ext_in[editorImage,jpg,jpeg,png]|max_size[editorImage,1024]|uploaded[editorImage]',
        ];
        $data['errors'] = [
            'editorImage' => [
                'max_size' => lang('DF_Validation.errors.max_size', ['imageSize' => '1mb']),
                'ext_in' => lang('DF_Validation.errors.ext_in', ['imageExtensions' => 'jpg,jpeg,png']),
                'uploaded' => lang('DF_Validation.errors.uploaded',['whichOne' =>lang('DF_Validation.errors.editorImage')]),
            ],
        ];
        return $data;
    }


    public function contentValidator()
    {
        $data = [];
        $data['rules'] = [
            'title' => 'required|escUserInput[title]|min_length[' . $this->limits->titleMin . ']|max_length[' . $this->limits->titleMax . ']|validateContentSlug[title]',
            'contentCalculator' => 'required|min_length[' . $this->limits->contentMin . ']|max_length[' . $this->limits->contentMax . ']',
        ];
        $data['errors'] = [
            'title' => [
                'required' => lang('DF_Validation.errors.required_title'),
                'min_length' => lang('DF_Validation.errors.min_length_title', ['titleMin' => $this->limits->titleMin]),
                'max_length' => lang('DF_Validation.errors.max_length_title', ['titleMax' => $this->limits->titleMax]),
                'validateContentSlug' => lang('DF_Validation.errors.validateContentSlug'),
                'escUserInput'=>lang('DF_Validation.errors.escUserInputForTitle'),
            ],
            'contentCalculator' => [
                'required' => lang('DF_Validation.errors.required_content'),
                'min_length' => lang('DF_Validation.errors.min_length_content', ['contentMin' => $this->limits->contentMin]),
                'max_length' => lang('DF_Validation.errors.max_length_content', ['contentMax' => $this->limits->contentMax])
            ]
        ];
        return $data;
    }

    public function loginValidator()
    {   $verify = new Captcha();
        $data = [];
        $data['rules'] = [
            'user_email' => 'required|min_length[' . $this->limits->emailMin . ']|max_length[' . $this->limits->emailMax . ']|valid_email',
            'user_password' => 'required|escUserInput[user_password]|min_length[' . $this->limits->passMin . ']|max_length[' . $this->limits->passMax . ']|validateUser[user_email,user_password]|checkSuspended[user_email]',
            $verify->responseCaptchaElementName => 'required',
        ];

        $data['errors'] = [
            $verify->responseCaptchaElementName => [
                'required' => lang('DF_Validation.errors.required_user_captcha'),
            ],
            'user_password' => [
                'required' => lang('DF_Validation.errors.required_login_pass'),
                'validateUser' => lang('DF_Validation.errors.validateUser'),
                'min_length' => lang('DF_Validation.errors.min_length_pass', ['passMin' => $this->limits->passMin]),
                'max_length' => lang('DF_Validation.errors.max_length_pass', ['passMax' => $this->limits->passMax]),
                'checkSuspended' => lang('DF_Validation.errors.checkSuspended'),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'user_email' => [
                'required' => lang('DF_Validation.errors.required_mail'),
                'min_length' => lang('DF_Validation.errors.login_mail'),
                'max_length' => lang('DF_Validation.errors.login_mail'),
                'valid_email' => lang('DF_Validation.errors.login_mail'),
            ]
        ];
        return $data;

    }

    public function newPassValidator()
    {
        $verify = new Captcha();
        $data = [];
        $data['rules'] = [
            'user_email' => 'required|min_length[' . $this->limits->emailMin . ']|max_length[' . $this->limits->emailMax . ']|valid_email|is_mail_have[user_email]',
            $verify->responseCaptchaElementName => 'required',
        ];
        $data['errors'] = [
            $verify->responseCaptchaElementName => [
                'required' => lang('DF_Validation.errors.required_user_captcha'),
            ],
            'user_email' => [
                'required' => lang('DF_Validation.errors.required_mail'),
                'min_length' => lang('DF_Validation.errors.login_mail'),
                'max_length' => lang('DF_Validation.errors.login_mail'),
                'valid_email' => lang('DF_Validation.errors.login_mail'),
                'is_mail_have' => lang('DF_Validation.errors.login_mail'),
            ]
        ];
        return $data;
    }

    public function userUpdateValidatorForAdminPanel($postrequest)
    {
        $data = [];

        $data['rules'] = [
            'user_email' => 'required|min_length[' . $this->limits->emailMin . ']|max_length[' . $this->limits->emailMax . ']|valid_email|user_update_validator_for_email[user_email]',
            'user_password' => 'min_length[' . $this->limits->passMin . ']|max_length[' . $this->limits->passMax . ']',
        ];
        $data['errors'] = [
            'user_email' => [
                'required' => lang('DF_Validation.errors.admin_control.panel.user_panel.required_mail'),
                'min_length' => lang('DF_Validation.errors.admin_control.panel.user_panel.user_email_min_length', ['emailMin' => $this->limits->emailMin]),
                'max_length' => lang('DF_Validation.errors.admin_control.panel.user_panel.user_email_max_length', ['emailMin' => $this->limits->emailMax]),
                'valid_email' => lang('DF_Validation.errors.admin_control.panel.user_panel.user_valid_email'),
                'user_update_validator_for_email' => lang('DF_Validation.errors.admin_control.panel.user_panel.user_email'),
            ],
            'user_password' => [
                'min_length' => lang('DF_Validation.errors.admin_control.panel.user_panel.user_min_length_pass', ['passMin' => $this->limits->passMin]),
                'max_length' => lang('DF_Validation.errors.admin_control.panel.user_panel.user_max_length_pass', ['passMax' => $this->limits->passMax]),
            ]
        ];
        $recognized = [];
        if (!empty($postrequest['user_password']) && !empty($postrequest['user_email'])) {
            $recognized['rules'] = [
                'user_email' => $data['rules']['user_email'],
                'user_password' => $data['rules']['user_password'],
            ];
            $recognized['errors'] = [
                'user_email' => $data['errors']['user_email'],
                'user_password' => $data['errors']['user_password'],
            ];
        }elseif (!empty($postrequest['user_password'])) {
            $recognized['rules'] = ['user_password' => $data['rules']['user_password']];
            $recognized['errors'] = ['user_password' => $data['errors']['user_password']];
        }elseif (!empty($postrequest['user_email'])) {
            $recognized['rules'] = ['user_email' => $data['rules']['user_email']];
            $recognized['errors'] = ['user_email' => $data['errors']['user_email']];
        }
        return $recognized;
    }

    public function createAdminValidatorForSetup()
    {
        $data = [];
        $data['rules'] = [
            'user_name' => 'required|min_length[' . $this->limits->firstnameMin . ']|max_length[' . $this->limits->firstnameMax . ']|is_unique[users.user_name]|alpha_numeric',
            'user_email' => 'required|min_length[' . $this->limits->emailMin . ']|max_length[' . $this->limits->emailMax . ']|valid_email|is_unique[users.user_email]',
            'user_password' => 'required|min_length[' . $this->limits->passMin . ']|max_length[' . $this->limits->passMax . ']',
            'user_password_confirm' => 'matches[user_password]',
        ];

        $data['errors'] = [
            'user_name' => [
                'required' => lang('DF_Validation.errors.required_user_name'),
                'min_length' => lang('DF_Validation.errors.min_length_user_name',['userNameMin' => $this->limits->firstnameMin ]),
                'max_length' => lang('DF_Validation.errors.max_length_user_name',['userNameMax' => $this->limits->firstnameMax ]),
                'is_unique' => lang('DF_Validation.errors.is_unique_user_name'),
                'alpha_numeric' => lang('DF_Validation.errors.alpha_numeric_user_name'),
            ],
            'user_password' => [
                'required' => lang('DF_Validation.errors.required_login_pass'),
                'min_length' => lang('DF_Validation.errors.min_length_pass', ['passMin' => $this->limits->passMin]),
                'max_length' => lang('DF_Validation.errors.max_length_pass', ['passMax' => $this->limits->passMax]),
            ],
            'user_password_confirm' => [
                'matches' => lang('DF_Validation.errors.matches_pass'),
            ],
            'user_email' => [
                'required' => lang('DF_Validation.errors.required_mail'),
                'min_length' => lang('DF_Validation.errors.min_length_user_mail',['emailMin'=> $this->limits->emailMin]),
                'max_length' => lang('DF_Validation.errors.max_length_user_mail',['emailMax'=> $this->limits->emailMax]),
                'valid_email' => lang('DF_Validation.errors.valid_user_email'),
                'is_unique' => lang('DF_Validation.errors.is_unique_user_mail'),
            ]
        ];
        return $data;
    }

    public function registerValidator()
    {
        $verify = new Captcha();
        $data = [];
        $data['rules'] = [
            'firstname' => 'required|escUserInput[firstname]|min_length[' . $this->limits->firstnameMin . ']|max_length[' . $this->limits->firstnameMax . ']',
            'lastname' => 'required|escUserInput[lastname]|min_length[' . $this->limits->firstnameMin . ']|max_length[' . $this->limits->firstnameMax . ']',
            'user_name' => 'required|min_length[' . $this->limits->firstnameMin . ']|max_length[' . $this->limits->firstnameMax . ']|is_unique[users.user_name]|alpha_numeric',
            'user_email' => 'required|min_length[' . $this->limits->emailMin . ']|max_length[' . $this->limits->emailMax . ']|valid_email|is_unique[users.user_email]',
            'user_password' => 'required|escUserInput[user_password]|min_length[' . $this->limits->passMin . ']|max_length[' . $this->limits->passMax . ']',
            'user_password_confirm' => 'matches[user_password]',
            $verify->responseCaptchaElementName => 'required',
        ];

        $data['errors'] = [
            $verify->responseCaptchaElementName => [
                'required' => lang('DF_Validation.errors.required_user_captcha'),
            ],
            'firstname' => [
                'required' => lang('DF_Validation.errors.required_first_name'),
                'min_length' => lang('DF_Validation.errors.min_length_first_name',['firstnameMin' =>$this->limits->firstnameMin]),
                'max_length' => lang('DF_Validation.errors.max_length_first_name',['firstnameMax' =>$this->limits->firstnameMax]),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'lastname' => [
                'required' => lang('DF_Validation.errors.required_last_name'),
                'min_length' => lang('DF_Validation.errors.min_length_last_name',['lastnameMin' =>$this->limits->firstnameMin]),
                'max_length' => lang('DF_Validation.errors.max_length_last_name',['lastnameMax' =>$this->limits->firstnameMax]),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'user_name' => [
                'required' => lang('DF_Validation.errors.required_user_name'),
                'min_length' => lang('DF_Validation.errors.min_length_user_name',['userNameMin' => $this->limits->firstnameMin ]),
                'max_length' => lang('DF_Validation.errors.max_length_user_name',['userNameMax' => $this->limits->firstnameMax ]),
                'is_unique' => lang('DF_Validation.errors.is_unique_user_name'),
                'alpha_numeric' => lang('DF_Validation.errors.alpha_numeric_user_name'),
            ],
            'user_password' => [
                'required' => lang('DF_Validation.errors.required_login_pass'),
                'min_length' => lang('DF_Validation.errors.min_length_pass', ['passMin' => $this->limits->passMin]),
                'max_length' => lang('DF_Validation.errors.max_length_pass', ['passMax' => $this->limits->passMax]),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'user_password_confirm' => [
                'matches' => lang('DF_Validation.errors.matches_pass'),
            ],
            'user_email' => [
                'required' => lang('DF_Validation.errors.required_mail'),
                'min_length' => lang('DF_Validation.errors.min_length_user_mail',['emailMin'=> $this->limits->emailMin]),
                'max_length' => lang('DF_Validation.errors.max_length_user_mail',['emailMax'=> $this->limits->emailMax]),
                'valid_email' => lang('DF_Validation.errors.valid_user_email'),
                'is_unique' => lang('DF_Validation.errors.is_unique_user_mail'),
            ]
        ];
        /*!$verify->getVerify($this->request->getVar($verify->responseCaptchaElementName))*/
        unset($verify);
        return $data;

    }

    public function profileUpdaterValidator()
    {
        $data = [];
        $data['rules'] = [
            'firstname' => 'required|escUserInput[firstname]|min_length[' . $this->limits->firstnameMin . ']|max_length[' . $this->limits->firstnameMax . ']',
            'lastname' => 'required|escUserInput[lastname]|min_length[' . $this->limits->firstnameMin . ']|max_length[' . $this->limits->firstnameMax . ']|escUserInput[lastname]',
            'user_password' => 'required|escUserInput[user_password]|min_length[' . $this->limits->passMin . ']|max_length[' . $this->limits->passMax . ']|escUserInput[user_password]',
            'user_password_confirm' => 'required|matches[user_password]'
        ];
        $data['errors'] = [
            'firstname' => [
                'required' => lang('DF_Validation.errors.required_first_name'),
                'min_length' => lang('DF_Validation.errors.min_length_first_name',['firstnameMin' =>$this->limits->firstnameMin]),
                'max_length' => lang('DF_Validation.errors.max_length_first_name',['firstnameMax' =>$this->limits->firstnameMax]),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'lastname' => [
                'required' => lang('DF_Validation.errors.required_last_name'),
                'min_length' => lang('DF_Validation.errors.min_length_last_name',['lastnameMin' =>$this->limits->firstnameMin]),
                'max_length' => lang('DF_Validation.errors.max_length_last_name',['lastnameMax' =>$this->limits->firstnameMax]),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'user_password' => [
                'required' => lang('DF_Validation.errors.required_login_pass'),
                'min_length' => lang('DF_Validation.errors.min_length_pass', ['passMin' => $this->limits->passMin]),
                'max_length' => lang('DF_Validation.errors.max_length_pass', ['passMax' => $this->limits->passMax]),
                'escUserInput'=> lang('DF_Validation.errors.escUserInput'),
            ],
            'user_password_confirm' => [
                'required' => lang('DF_Validation.errors.matches_pass'),
                'matches' => lang('DF_Validation.errors.matches_pass'),
            ],
        ];
        return $data;

    }

    public function commentValidator()
    {
        $data = [];
        $data['rules'] = [
            'comment' => 'required|min_length[' . $this->limits->commentMin . ']|max_length[' . $this->limits->commentMax . ']|validateComment[comment]',
        ];

        $data['errors'] = [
            'comment' => [
                'validateComment' => lang('DF_Validation.errors.valideComment'),
                'min_length' => lang('DF_Validation.errors.min_length_comment',['commentMin'=> $this->limits->commentMin]),
                'max_length' => lang('DF_Validation.errors.max_length_comment',['commentMax'=> $this->limits->commentMax]),
                'required' => lang('DF_Validation.errors.required_comment'),
            ]
        ];
        return $data;
    }

}