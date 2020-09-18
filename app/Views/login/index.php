<link href="<?php echo base_url() ?>/public/assets/css/specific/signin.css" rel="stylesheet">
<?php
if (!empty($loginIndex)) {
    echo $loginIndex['form_open'];
    if (session()->get('success')):
        echo '<div class="alert alert-success" role="alert">' .
            session()->get('success')
            . '</div>';
    endif;
    echo '<img class="mb-4" src="' . $loginIndex['loginLogoLink'] . '" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">'. lang('View.login.index.pleaseLoginLabel') .'</h1>';
    echo $loginIndex['formReady'];
    if (isset($validation)):
        echo '<div class="col-12">
        <div class="alert alert-danger" role="alert">'.
            $validation->listErrors() .
            '</div>
    </div>';
    endif;
    $captchaSiteKey = getenv('capctcha_site_key');
    if (!empty($captchaSiteKey)) {
        echo '<div class="row mt-3 mb-3">
                        <div class="col-12 col-sm-4">
                            <div class="g-recaptcha" data-sitekey="' . $captchaSiteKey . '"></div>
                        </div>
                    </div>';
    }else{
        // We can manipulate this when no have google key..
        echo '<input type="hidden" name="g-recaptcha-response" value="true">';
    }
    echo '<button class="btn btn-lg btn-primary btn-block" type="submit">'. lang('View.login.index.login') .'</button>
          <div class="mt-5 mb-3 text-center"><a href="register">'. lang('View.login.index.register') .'</a></div>
          <div class="mt-5 mb-3 text-center"><a href="forgot">' . lang('View.login.index.forgot') . '</a></div>';
    echo $loginIndex['form_close'];
}
?>
<?php if (!empty($captchaSiteKey)) { ?>
    <script src='https://www.google.com/recaptcha/api.js?hl=tr'></script>
<?php } ?>
