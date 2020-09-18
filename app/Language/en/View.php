<?php
$adminPanel = require 'DF_AdminPanel_view_en.php';
$dashboard = require 'DF_Dashboard_view_en.php';
$footer = require 'DF_Footer_view_en.php';
$header = require 'DF_Header_view_en.php';
$login = require 'DF_Login_view_en.php';
$nav = require 'DF_Nav_view_en.php';
$profile = require 'DF_Profile_view_en.php';
$publicContent = require 'DF_PublicContent_view_en.php';
$register = require 'DF_Register_view_en.php';
$setup = require 'DF_Setup_view_en.php';
$shared = require 'DF_Shared_view_en.php';
return [
    'AdminPanel' => [
        'website' => $adminPanel['website'],
        'general' => $adminPanel['general'],
        'enabledChecker' => $adminPanel['enabledChecker'],
        'mailConf' => $adminPanel['mailConf'],
        'awsConf' => $adminPanel['awsConf'],
        'captchaConf' => $adminPanel['captchaConf'],
        'imageLocationConf' => $adminPanel['imageLocationConf'],
        'report' => $adminPanel['report'],
        'users' => $adminPanel['users'],
        'content' => $adminPanel['content'],
    ],
    'dashboard' => [
        'contents' => $dashboard['contents'],
        'editor' => $dashboard['editor'],
    ],
    'header' => $header['index'],
    'footer' => $footer['index'],
    'login' => $login,
    'register' => $register,
    'nav' => $nav,
    'profile' => $profile,
    'publicContent' => $publicContent,
    'shared' => $shared,
    'setup' => $setup,
];