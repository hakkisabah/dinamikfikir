<?php
echo '<!DOCTYPE html><html lang="tr">';
echo '
<head>
<meta name="Content-type"content="text/html; charset=utf-8">
<meta name="viewport"content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>';
$sideTitle = !empty(getenv('SITE_NAME')) ? getenv('SITE_NAME') : lang('View.setup.index.sideTitle');
echo '<body class="bg-light">';
echo '<link href="public/assets/css/bootstrap/bootstrap.4.5.min.css" rel="stylesheet" type="text/css" />';
echo '<nav  class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
<a class="navbar-brand text-center">' . $sideTitle . '</a>
<div class="collapse navbar-collapse" id="navbarsExample07"><ul class="navbar-nav mr-auto">
 <li class="nav-item dropdown">
   <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dil / Language</a>
     <div class="dropdown-menu" aria-labelledby="dropdown07">
        <a class="dropdown-item" onclick="setLocale(1)">Türkçe</a>
        <a class="dropdown-item" onclick="setLocale(2)">English</a>
    </div>
 </li>
</ul>
</div></nav>';
echo '<main role="main" class="container mt-5">';
?>
<?php if (!empty($setup) && $setup == 'ON') {
    ?>
    <div class="row">
        <div class="col-md-12 mt-3 pt-3 pb-3 form-wrapper">
            <div class="container">
                <?php
                echo view('setup/color_info');
                ?>
            </div>
        </div>
    </div>
    <style>
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            /*
            Linklerin aynı renkte görünmesi için yapılan modifikasyon
            */
            /* Added by Hakkı SABAH */
            background-color: transparent !important;
            /* Added by Hakkı SABAH END */
        }
    </style>
    <?php echo view('setup/index/tabs') ?>
    <div class="row">
        <div class="col-md-2">
            <div class="col-md-2 text-left">
                <a id="saveForSetup" class="btn btn-primary position-fixed d-none" style="
    bottom: 50px;
    left: 10px; " onclick="saveSetup(this)" role="button"><?php echo lang('View.setup.index.save'); ?></a>
            </div>
        </div>
    </div>
    <?php
} else {
    if (!empty($setup) && $setup == 'OFF') {
        echo lang('View.setup.index.setupError');
    }
}
echo '</main>';
?>
<?php echo view('setup/index/scripts') ?>
</body>
</html>