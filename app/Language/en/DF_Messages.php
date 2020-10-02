<?php

return [
    'messages' => [
        'flashData' => [
            'userRequest' => [
                'afterRegisterForMailActivation' => 'After confirming the activation link in your e-mail, you can login. Do not forget to check the spam box in your mail! ',
                'succesWithoutActivation' => 'You can login with your email address that you have successfully registered.',
                'userNeededActivation' => 'Please use the activation link in your email for the activation process.',
                'userNeedNewPassButActiovationNotWork' => 'Mail system is not currently active, please contact the administrators.',
                'userLaterForActivation' => 'You seem to be late for the activation process. You must register again. ',
                'newPass' =>' After clicking the password reset link in your e-mail, reset your password in your account settings. Do not forget to check the spam box in your mail! ',
                'newPassFail' => 'Your password reset operation cannot be processed at this time ..',
                'newPassReminder' => "Please don't forget to change your password!",
                'successRecord' => 'Registration Successfully Updated',
                'locationChanges' => 'Location changing when is done, you can continue content operations in about 1 minute.',
            ],
        ],
        'HTTP' => [
            'userRequest' => [
                'registerFail' => 'Your registration cannot be processed right now ..',
                'activationEndPointFail' => 'Activation link extension is not set in the system, please contact the administrators',
                'newPassFail' => 'Your password reset operation cannot be processed at this time ..',
                'activationCodeRefused' => 'Your activation code is invalid.',
            ],
            'imageRequest' => [
                'tempImageErrorIsValid' => 'Please upload a valid file',
            ],
            'userLogic'=>[
                'serverProblem' => 'There is a server based problem.',
            ],
            'errors'=>[
                'title' =>'Whoopss',
                'message'=>'We seem to have hit a snag... {pageroute}',
            ]
        ],
        'SMTP' => [
            'userRequest' => [
                'activationMailSubject' => '{site_name} user account activation',
                'newPassSubject' => '{site_name} password reset',
            ],

        ],
    ],
];