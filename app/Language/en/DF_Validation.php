<?php

$adminValidation = require 'DF_Admin_Validation_en.php';
return [
    'errors' => [
        'admin_control'=>$adminValidation['errors']['admin_control'],
        'max_size' => 'The file size you upload cannot exceed {imageSize}.',
        'ext_in' => 'Only formats with the extension {imageExtensions} can be uploaded.',
        'uploaded' => 'Please upload a readable file',
        'uploaded' => 'Please upload a readable {whichOne} image',
        'editorImage' => 'content',
        'titleImage' => 'title',
        'escUserInput' => 'There are unlikable characters among the information you have entered.',
        'escUserInputForTitle' => 'You did not enter the correct expression for the title, check.',

        'required_mail' => 'You must enter your mail address.',
        'login_mail' => 'Please use valid email address that you specified while registering',
        'required_title' => 'You need to enter a title.',
        'required_content' => 'Please enter some content.',
        'required_comment' => 'An empty comment cannot be submitted.',
        'required_login_pass' => 'You need to enter a password',
        'matches_pass' => 'Your password confirmation did not pass, please try again by entering the same passwords.',
        'required_user_name' => 'Please specify a username',
        'required_user_captcha' => 'Please confirm that you are not an automation software by clicking the "I am not a robot" box on this form',
        'required_first_name' => 'Please specify a first name.',
        'required_last_name' => 'Please specify a last name.',

        'min_length_first_name' => 'Please check your name cannot be less than {firstnameMin} characters',
        'max_length_first_name' => 'Please check your name cannot be more than {firstnameMax} characters',
        'min_length_last_name' => 'Please check your last name cannot be less than {lastnameMin} characters',
        'max_length_last_name' => 'Please check your last name cannot exceed {lastnameMax} characters',
        'min_length_pass' => 'Your password cannot be less than {passMin} characters, please check',
        'max_length_pass' => 'Your password cannot exceed {passMax} characters please check',
        'min_length_user_name' => 'Check your username cannot be less than {userNameMin} characters',
        'max_length_user_name' => 'Check that your username cannot be more than {userNameMax} characters',
        'min_length_user_mail' => 'Please use a valid email address. Must contain a minimum of {emailMin} characters',
        'max_length_user_mail' => 'Please use a valid email address. Must contain maximum {emailMax} characters',
        'min_length_title' => 'Title must contain at least {titleMin} characters',
        'max_length_title' => 'Title must contain cannot be more than {titleMax} characters',
        'min_length_content' => 'Your content must contain at least {contentMin} characters.',
        'max_length_content' => 'Your content must contain a maximum of {contentMax} characters.',
        'min_length_comment' => 'Please write a comment with at least {commentMin} characters.',
        'max_length_comment' => 'You can write a comment with a maximum of {commentMax} characters.',

        'is_unique_user_name' => 'This username is in use, please try a different username',
        'is_unique_user_mail' => 'This email address seems to have been used before, if the account belongs to you, you can log in with your password',
        'alpha_numeric_user_name' => 'Your username should only consist of letters and numbers, no spaces and only English characters',
        'checkSuspended' => 'Your account has been suspended, please contact system administrators ..',

        'validateContentSlug' => 'This title is not available, please enter a legible and not previously used title.',
        'valid_user_email' => 'Please use a valid email address',
        'validateUser' => 'Email or username does not match',
        'valideComment' => 'Do not use any html tags for security reasons ..',
    ],


];