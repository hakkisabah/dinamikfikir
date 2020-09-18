<?php
/**
 * View language strings.
 *
 * @package      CodeIgniter
 * @author       CodeIgniter Dev Team
 * @copyright    2014-2019 British Columbia Institute of Technology (https://bcit.ca/)
 * @license      https://opensource.org/licenses/MIT	MIT License
 * @link         https://codeigniter.com
 * @since        Version 3.0.0
 * @filesource
 * 
 * @codeCoverageIgnore
 */
$adminPanel = require 'DF_AdminPanel_view.php';
$dashboard = require 'DF_Dashboard_view.php';
$footer = require 'DF_Footer_view.php';
$header = require 'DF_Header_view.php';
$login = require 'DF_Login_view.php';
$register = require 'DF_Register_view.php';
$nav = require 'DF_Nav_view.php';
$profile = require 'DF_Profile_view.php';
$publicContent = require 'DF_PublicContent_view.php';
$shared = require 'DF_Shared_view.php';
$setup = require 'DF_Setup_view.php';
return [
    'AdminPanel'=>[
        'website'=>$adminPanel['website'],
        'general'=>$adminPanel['general'],
        'enabledChecker'=>$adminPanel['enabledChecker'],
        'mailConf'=>$adminPanel['mailConf'],
        'awsConf'=>$adminPanel['awsConf'],
        'captchaConf'=>$adminPanel['captchaConf'],
        'imageLocationConf'=>$adminPanel['imageLocationConf'],
        'report'=>$adminPanel['report'],
        'users'=>$adminPanel['users'],
        'content'=>$adminPanel['content'],
    ],
    'dashboard'=>[
        'contents'=>$dashboard['contents'],
        'editor'=>$dashboard['editor'],
    ],
    'header'=>$header['index'],
    'footer'=> $footer['index'],
    'login'=>$login,
    'register'=>$register,
    'nav'=>$nav,
    'profile'=>$profile,
    'publicContent'=>$publicContent,
    'shared'=>$shared,
    'setup'=>$setup,
	'invalidCellMethod'     => '{class}::{method} geçerli bir yöntem değil.',
	'missingCellParameters' => '{class}::{method} yönteminin parametresi yok.',
	'invalidCellParameter'  => '{0} geçerli bir parametre adı yok.',
	'noCellClass'           => 'Görüntü hücre sınıfı belirtilmemiş.',
	'invalidCellClass'      => 'Görüntü hücre sınıfı bulunamıyor: {0}.',
	'tagSyntaxError'        => 'Çözümleyici etiketlerinde yazım hatası var: {0}',
];
