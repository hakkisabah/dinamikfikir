<?php

return [
    'index' => [
        'sideTitle' => 'Setup',
        'save' => 'Save',
        'setupError' => 'Database error, unable to connect to previously configured database',
    ],
    'tabs' => [
        'manuNames' => [
            'database' => 'Database',
            'adminAccount' => 'Administrator Account',
            'mailSettings' => 'Mail Settings',
            'captcha' => 'Google Captcha',
            'aws' => 'AWS Settings',
        ],
    ],
    'scripts' => [
        'shouldSettingsNoChange' => 'It is recommended that you do not change your settings too much.',
        'readyForStart' => "YOU'RE READY! You have now made the necessary adjustments. If you want, you can click the save button to make the remaining settings from your admin panel!",
        'readyDb' => ' successfully running, now you need to set an administrator account ..',
        'successTestMail' => ' successfully verified ..',
        'successCreatedAdmin' => ' successfully created.',
        'successAWS' => ' info verified sync successful!',
        'successCaptcha' => ' information received',
        'show' => 'Show',
        'close' => 'Close',
        'testSenderNotConfirm' =>' unable to verify .. Please try again after checking'
    ],
    'color_info' => [
        'titleColorFirst' => 'Title Colors',
        'titleColorLast' => ' click to get information about',
        'beMust' => 'Required',
        'beRequired' => 'Must be',
        'fastSystem' => 'Fast system',
        'lowModerate' => 'Low importance',
    ],
    'databaseConf' => [
        'databaseCardLabel' => 'Database Settings',
        'databaseInfoLabel' => 'Database information',
        'databaseExplanation' => 'Please test after entering database information.',
        'target' => 'target',
        'targetPlaceHolder' => 'Example: localhost',
        'userName' => 'User name',
        'userNamePlaceHolder' => 'Example: root',
        'pass' => 'Password',
        'passPlaceHolder' => 'Enter database password',
        'databaseName' => 'Database name',
        'databaseNamePlaceHolder' => 'Example: dinamikfikir',
        'test' => 'Test',
    ],
    'adminUserConf' => [
        'adminCardLabel' => 'Administrator Account Settings',
        'adminInfoLabel' => 'Account information',
        'adminExplanation' => 'Enter the username and other information you want to use. User by default
             Your name is set as admin. ',
        'userName' => 'User name',
        'userNamePlaceHolder' => 'Example: admin',
        'mailAddress' => 'Mail address',
        'mailAddressPlaceHolder' => 'Enter your mail address',
        'userPass' => 'Password',
        'userPassPlaceHolder' => 'Set password for the account',
        'userPassConfrim' => 'Password repeat',
        'userPassConfrimPlaceHolder' => 'Re-enter your password',
        'create' => 'Create',

    ],
    'mailConf' => [
        'show' => 'Show',
        'mailCardLabel' => 'Mail Settings',
        'mailInfoLabel' => 'Mail sending settings',
        'mailExplanation' => 'To perform password reminder, activation mail, etc. processes on your system
             You need to adjust your mail settings. If these settings are not made, you will not be able to use these features.
             You should definitely test your mail account .. In addition, after installation, detailed mail settings are in the admin panel.
             will welcome you .. ',
    ],
    'capctchaConf' => [
        'captchaCardLabel' => 'Google Captcha Settings',
        'captchaInfoLabel' => 'Google captcha keys',
        'captchaExplanation' => 'If you enter site keys that are hidden and public by Google, the system
             will check whether the guest is a robot during the new registration. ',
    ],
    'awsSystem' => [
        'awsCardLabel' => 'AWS System',
        'show' => 'Show',
        'awsInfoLabel' => 'AWS information',
        'awsExplanation' => 'Integrated with the AWS s3 system, you can greatly reduce the system load!
          Please enter the required information for settings .. ',
    ],
    'defaultMailEnv'=>[
        'MAIL_NAME' => ' Mail Service',
        'MAIL_DEFAULT_SUBJECT' => ' sent you a mail',
        'MAIL_DEFAULT_MESSAGE_WELCOME' => ' to confirm your welcome account',
        'MAIL_DEFAULT_MESSAGE_LINK_TEXT' => ' click here',
        'MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT' => 'If you cannot click the link, this address is: ',
        'MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT2' => ' you can log in with your browser by copying',
    ],

];