<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    // Makes reading things below nicer,
    // and simpler to change out script that's used.
    public $aliases = [
        'csrf' => \CodeIgniter\Filters\CSRF::class,
        'toolbar' => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'auth' => \App\Filters\Auth::class,
        'adminauth' => \App\Filters\AdminAuth::class,
        'noauth' => \App\Filters\Noauth::class,
        'userscheck' => \App\Filters\UsersCheck::class,
        'ownership' => \App\Filters\Ownership::class,
//        'sessionupdater' => \App\Filters\SessionUpdater::class,
        'notificationsetter' => \App\Filters\NotificationSetter::class,
//        'indexdataupdater' => \App\Filters\IndexDataUpdater::class,
        'publicrequest' => \App\Filters\PublicRequest::class,
        'ipandlocationlogger' => \App\Filters\IpAndLocationLogger::class,
        'setupdetector' => \App\Filters\setupDetector::class,
        'localization' => \App\Filters\Localization::class,
        'locationtimer' => \App\Filters\LocationTimer::class,
        'xmlchecker' => \App\Filters\XMLChecker::class,
    ];

    // Always applied before every request
    public $globals = [
        'before' => [
            //'honeypot'
            // 'csrf',
        ],
        'after' => [
            'toolbar',
            //'honeypot'
        ],
    ];

    // Works on all of a particular HTTP method
    // (GET, POST, etc) as BEFORE filters only
    //     like: 'post' => ['CSRF', 'throttle'],
    public $methods = [];

    // List filter aliases and any before/after uri patterns
    // that they should run on, like:
    //    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
    public $filters = [
        'xmlchecker'=>[
            'before'=>[
                'sitemap.xml',
                'sitemap/year/*',
            ]
        ],
        'locationtimer'=>[
            'before'=>[
                'dashboard/editor',
                'dashboard/editor/*',
                'dashboard/updatecontent',
                'dashboard/addcontent',
            ]
        ],
        'localization'=>[
            'before'=>[

            ],
        ],
        'setupdetector'=>[
            'before'=>[
                'setup/*',
            ],
        ],
        'ipandlocationlogger' =>[
            'before'=>[
                // All pages when visiting check db connection
            ],
            'after'=>[
                // its always blank because we need touch every request
                // bütün istekleri yakalayabilmek adına boş bırakıyoruz
            ]
        ],
        'publicrequest'=>[
            'before'=>[
                'profile/*'
            ],
        ],
        'notificationsetter' => [
            'after' => [
                'content/addcomment',
            ],
        ],
        'ownership' => [
            'before' => [
                'dashboard/editor/*',
                'dashboard/updatecontent',
                'deletecontent/*',
                'comment/delete/*',
            ],
        ],
//        'sessionupdater' => [
//            'before' => [
//                // Güncel bildirimlerin alınabilmesi için.
//                'users/profile',
//                'dashboard',
//                'dashboard/contents',
//            ],
//            'after' => [
//                'users/islogin',
//                'dashboard/updatecontent',
//                'dashboard/addcontent',
//                'dashboard/deletecontent/*',
//                'save/avatar',
//                'read/notification',
//                'content/addcomment',
//                'comment/delete',
//            ],
//        ],
    ];
}
