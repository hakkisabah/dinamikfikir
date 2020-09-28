<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
//$routes->setDefaultController('Setup');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'View\Page::home'/*,['filter' => 'indexdataupdater']*/);

/*
 * SEO
 */
$routes->get('sitemap\.xml','Organizer\Sitemap::groupContentDateForSiteMap');
$routes->group('sitemap',function ($routes){
    $routes->get('(:num)\-(:num)\.xml','Organizer\Sitemap::getGroupedMonthFromRequest/$1/$2');
});

/*
 * SEO END
 */

// Developing
// If you learn and develop this may be first removed this comment line
//$routes->group('yourcontroller',function ($routes){
//    $routes->get('getcontent/(:any)', 'YourController\Controller::getContent/$1');
//    $routes->get('getuser/(:any)', 'YourController\Controller::getUser/$1');
//});
// Developing END

$routes->group('setup',function ($routes){
    $routes->post('testmailforsetup', 'Setup::testMailForSetup');
    $routes->post('testdbforsetup', 'Setup::dbConnectionChecker');
    $routes->post('createadminforsetup', 'Setup::createAdminForSetup');
    $routes->post('testawsforsetup', 'Setup::testAwsForSetup');
    $routes->post('savesetup', 'Setup::saveSetup');
});


$routes->group('admin', function($routes){
    // Admin - Get
    $routes->get('report', 'View\Page::adminReport',['filter' => 'adminauth']);
    $routes->get('site', 'View\Page::adminSite',['filter' => 'adminauth']);
    $routes->get('users', 'View\Page::adminUsers',['filter' => 'adminauth']);
    $routes->get('contents', 'View\Page::adminContents',['filter' => 'adminauth']);
    // Admin - Post
    // Reports
    $routes->post('usersreport', 'Requests\AdminRequests::usersReport',['filter' => 'adminauth']);
    $routes->post('generalusersreport', 'Requests\AdminRequests::generalUsersReport',['filter' => 'adminauth']);
    // User
    $routes->post('updateuser', 'Requests\AdminRequests::updateUser',['filter' => 'adminauth']);
    $routes->post('searchuser', 'Requests\AdminRequests::searchUser',['filter' => 'adminauth']);
    // Content
    $routes->post('searchcontent', 'Requests\AdminRequests::searchContent',['filter' => 'adminauth']);
    $routes->post('deletecontent', 'Requests\AdminRequests::deleteContent',['filter' => 'adminauth']);
    // Site
    $routes->post('uploadsiteconf', 'Requests\AdminRequests::setSiteConf',['filter' => 'adminauth']);
    $routes->post('testmail', 'Requests\AdminRequests::testMail',['filter' => 'adminauth']);
    $routes->post('testaws', 'Requests\AdminRequests::testAws',['filter' => 'adminauth']);
    $routes->post('reactivation', 'Requests\AdminRequests::reActivation',['filter' => 'adminauth']);

    // Maintance
    $routes->post('locationsuspend', 'Requests\AdminRequests::locationSuspend',['filter' => 'adminauth']);
});
// User Auth process..
$routes->group('users', function($routes)
{
    // Activation
    $routes->get('activation/(:any)', 'Requests\UserRequest::userActivation/$1');
    // Request - GET
    $routes->get('login', 'View\Page::login',['filter' => 'noauth']);
    $routes->get('forgot', 'View\Page::forgot',['filter' => 'noauth']);
    $routes->get('register', 'View\Page::register',['filter' => 'noauth']);
    // Require Auth
    $routes->get('profile', 'View\Page::profile',['filter' => 'auth']);
    $routes->get('logout', 'Requests\UserRequest::logout',['filter' => 'auth']);

    // Request - POST
    $routes->post('islogin', 'Requests\UserRequest::islogin',['filter' => 'noauth']);
    $routes->post('newpass', 'Requests\UserRequest::newPass',['filter' => 'noauth']);
    $routes->post('register', 'Requests\UserRequest::register',['filter' => 'noauth']);
    // Require Auth
    $routes->post('profile', 'Requests\UserRequest::profile',['filter' => 'auth']);

});


// Logged user process..

// -- Dashboard
$routes->group('dashboard', function($routes)
{
    // Request - Page
    $routes->get('/', 'View\Page::dashboardIndex',['filter' => 'auth']);
    $routes->get('contents', 'View\Page::contents',['filter' => 'auth']);
    $routes->group('editor', function($routes)
    {
        $routes->get('/', 'View\Page::editor',['filter' => 'auth']);
        $routes->get('(:any)', 'View\Page::editor/$1',['filter' => 'auth']);
    });

    // Request - POST
    // images
    $routes->post('uploadimage', 'Requests\ImageRequest::uploadImage',['filter' => 'auth']);
    $routes->post('userleaveremovetempimage', 'Requests\ImageRequest::removeTempImages',['filter' => 'auth']);
    $routes->post('removesingletempimage', 'Requests\ImageRequest::removeSingleTempImage',['filter' => 'auth']);
    // contents
    $routes->post('updatecontent', 'Requests\ContentRequest::updatecontent',['filter' => 'auth']);
    $routes->post('addcontent', 'Requests\ContentRequest::addcontent',['filter' => 'auth']);

    // Request - GET
    $routes->get('deletecontent/(:any)', 'Requests\ContentRequest::deletecontent/$1',['filter' => 'auth']);

});

// -- Shared process and public request..

// Content
$routes->post('content/addcomment', 'Requests\CommentRequest::setComment',['filter' => 'auth']);
$routes->get('comment/delete/(:num)', 'Requests\CommentRequest::deleteComment/$1',['filter' => 'auth']);
$routes->get('content/(:any)', 'View\Page::publiccontent/$1');

// User ..
$routes->get('profile/(:alphanum)', 'View\Page::publicProfile/$1',['filter' => 'publicrequest']);

// JavasScript Ajax ..
$routes->post('save/avatar', 'Extension\Icons::saveAvatar',['filter' => 'auth']);
$routes->post('read/notification', 'SharedData\Notifications::readNotification',['filter' => 'auth']);

// KVKK
$routes->get('info/KVKK','View\Page::KVKK');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
