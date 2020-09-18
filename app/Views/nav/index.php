</head>
<body class="bg-light">
<?php
$navLogoText = !$navIndex['SITE_NAME'] ? $_SERVER['SERVER_NAME'] : $navIndex['SITE_NAME'];
echo '<link href="' . $navIndex['currentBase'] . 'public/assets/css/specific/offcanvas.css" rel="stylesheet">';
echo '<nav  class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand text-truncate" href="/">' . $navLogoText . '</a>';
echo '<button class="navbar-toggler p-0 border-0" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>';
// Bu sayfada bulunan ve yorum satırında bulunan #NAV-A-22 kodlu div bloğunu ezmemek için buradaki şart geliştirilmiştir..
// #NAV-A-22
echo '<div class="collapse navbar-collapse" id="navbarsExample07">
        <ul class="navbar-nav mr-auto">';
// #NAV-A-22 END
if ($navIndex['userInfo']['isLoggedIn']) {
    $isAdmin = !empty($navIndex['isAdmin']) ?
        '<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . lang('View.nav.index.menu.Admin.menuName') . '</a>
         <div class="dropdown-menu" aria-labelledby="dropdown07">
                    <a class="dropdown-item" href="/admin/report">' . lang('View.nav.index.menu.Admin.reports') . '</a>
                    <a class="dropdown-item" href="/admin/site">' . lang('View.nav.index.menu.Admin.siteSettings') . '</a>
                    <a class="dropdown-item" href="/admin/users">' . lang('View.nav.index.menu.Admin.userSettings') . '</a>
                    <a class="dropdown-item" href="/admin/contents">' . lang('View.nav.index.menu.Admin.contentSettings') . '</a>
         </div>
        </li>'
        : '';
    echo
        '<li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . lang('View.nav.index.menu.menuName') . '</a>
                <div class="dropdown-menu" aria-labelledby="dropdown07">
                    <a class="dropdown-item" href="/users/profile">' . lang('View.nav.index.menu.accountInfo') . '</a>
                    <a class="dropdown-item" href="/dashboard/editor">' . lang('View.nav.index.menu.createContent') . '</a>
                    <a class="dropdown-item" href="/users/logout">' . lang('View.nav.index.menu.logout') . '</a>
                </div>
        </li>' .
        $isAdmin .
        '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dil / Language</a>
                <div class="dropdown-menu" aria-labelledby="dropdown07">
                    <a class="dropdown-item" type="button" onclick="setLocale(1)">Türkçe</a>
                    <a class="dropdown-item" type="button" onclick="setLocale(2)">English</a>
                </div>
        </li>' .
        '</ul>
      </div>' .
        // aşağıdaki yorum satırındaki a etiketi aktif olduğunda <div class="nav-scroller bg-white shadow-sm"> divini ezmekte bu
        // div giriş yapmış olan kullanıcılara panel navigasyonu sunmaktadır.. isteğe göre geliştirilip kullanılabilir..
//        '<a class="btn btn-outline-primary col-md-1 mt-2" href="' . $navIndex['loginButton']['link'] . '">' . $navIndex['loginButton']['buttonText'] . '</a>' .
        '</nav>';
    echo '<div class="nav-scroller bg-white shadow-sm">
          <nav class="nav nav-underline">';
    echo '<a class="nav-link' . $navIndex['isActive']['dashboard'] . '" href="/dashboard">' . lang('View.nav.index.menu.subMenu.panel') . '</a>';
    echo '<a class="nav-link' . $navIndex['isActive']['contents'] . '" href="/dashboard/contents">
             ' . lang('View.nav.index.menu.subMenu.things') . '
            <span class="badge badge-pill bg-light align-text-bottom">' . $navIndex['isActive']['contentsCount'] . '</span>
           </a>';
    echo ' <a class="nav-link' . $navIndex['isActive']['editor'] . '" href="/dashboard/editor">
            ' . lang('View.nav.index.menu.subMenu.editor') . '
           </a>';
    // olması gereken ve kapatılması gereken login/logout opsiyonuna göre elementlerin id nosu : 234235
    // aynı id ile bağlantılı şarta bağlı kapatma nosu bulunmakta
    echo '</nav></div>';
} else {
    echo
    '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dil / Language</a>
                <div class="dropdown-menu" aria-labelledby="dropdown07">
                    <a class="dropdown-item" type="button" onclick="setLocale(1)">Türkçe</a>
                    <a class="dropdown-item" type="button" onclick="setLocale(2)">English</a>
                </div>
        </li>';
    if (!$navIndex['whichPage']) {
        echo '</ul></div>';
        echo '<a class="btn btn-outline-primary col-md-2 mt-2" href="' . $navIndex['loginButton']['link'] . '">' . $navIndex['loginButton']['buttonText'] .
            '</a>';
    }
    // olması gereken ve kapatılması gereken login/logout opsiyonuna göre elementlerin id nosu : 234235
    // aynı id ile bağlantılı şarta bağlı kapatma nosu bulunmakta
    echo '</nav></div>';
}
echo '<main role="main" class="container">';
