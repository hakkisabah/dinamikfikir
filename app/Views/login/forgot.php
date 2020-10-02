<link href="<?php echo !empty($forgotIndex['signinCss'])?$forgotIndex['signinCss']:'notfound-required-signinCss' ?>" rel="stylesheet">
<form action="/users/newpass" class="form-signin" method="post" accept-charset="utf-8">
    <div class="img-fluid mt-5">
        <img src="<?php echo !empty($forgotIndex['loginLogoLink'])?$forgotIndex['loginLogoLink']:'notfound-required-signinCss' ?>" alt="" width="72" height="72">
    </div>
    <h4 class="h4 mb-3 font-weight-normal mt-3"><?php echo lang('View.login.forgot.forgotLabel'); ?></h4>
    <label for="user_email" class="sr-only"><?php echo lang('View.login.forgot.mailAddress'); ?></label>
    <input type="email" name="user_email" value="" id="inputEmail" class="form-control mb-4"
           placeholder="<?php echo lang('View.login.forgot.mailAddress'); ?>"
           required autofocus/>
    <?php
    if (session()->get('success')):
        echo '<div class="alert alert-success" role="alert">' .
            session()->get('success')
            . '</div>';
    endif;
    if (isset($validation)):
        echo '<div class="col-12">
        <div class="alert alert-danger" role="alert">' .
            $validation->listErrors() .
            '</div>
    </div>';
    endif;
    ?>
    <?php
    $captchaSiteKey = getenv('capctcha_site_key');
    if (!empty($captchaSiteKey)) {
        echo '<div class="row mt-3 mb-3">
                        <div class="col-12 col-sm-4">
                            <div class="g-recaptcha" data-sitekey="' . $captchaSiteKey . '"></div>
                        </div>
                    </div>';
    } else {
        // We can manipulate this when no have google key..
        echo '<input type="hidden" name="g-recaptcha-response" value="true">';
    }
    ?>
    <button class="btn btn-lg btn-primary btn-block mt-4"
            type="submit"><?php echo lang('View.login.forgot.renew'); ?></button>
    <div class="mt-5 mb-3 text-center"><a href="register"><?php echo lang('View.login.index.register'); ?></a></div>
</form>

<?php if (!empty($captchaSiteKey)) { ?>
    <script src='https://www.google.com/recaptcha/api.js?hl=tr'></script>
<?php } ?>