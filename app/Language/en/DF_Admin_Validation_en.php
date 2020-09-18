<?php
return [
    'errors' => [
        'admin_control' => [
            'panel' => [
                'user_panel' => [
                    'required_mail' => "The user's mail must be defined.",
                    'user_email_min_length' => 'Please use a valid email address. Must contain a minimum of {emailMin} characters',
                    'user_email_max_length' => 'Please use a valid email address. Must contain maximum {emailMax} characters',
                    'user_valid_email' => 'The email address entered is not valid, please try a valid address',
                    'user_email' => 'This mail belongs to another user',
                    'user_min_length_pass' => 'User password cannot be less than {passMin} characters please check',
                    'user_max_length_pass' => 'User password cannot exceed {passMax} characters please check',
                    'adminNotUpdateExternally' => 'Admin cannot update itself externally',
                    'noProcess' => 'No action taken',
                ],

            ],
        ],
    ],
];