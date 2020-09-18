<div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 from-wrapper">
    <?php
    if (session()->get('success')):
        echo '<div class="alert alert-success" role="alert">' .
            session()->get('success')
            . '</div>';
    endif;
    ?>
    <h3><?php echo lang('View.register.index.signUp'); ?></h3>
    <hr>
    <?php
    if (!empty($registerIndex)) {
        echo $registerIndex['form_open'];
        echo '<div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">';
        echo $registerIndex['formReady']['user_name'][0];
        echo $registerIndex['formReady']['user_name'][1];
        echo '</div>
                   </div>
                   <div class="col-12 col-sm-6">

                   </div>';
        echo '<div class="col-12 col-sm-6">
                            <div class="form-group">';
        echo $registerIndex['formReady']['firstname'][0];
        echo $registerIndex['formReady']['firstname'][1];
        echo '</div>
                   </div>';
        echo '<div class="col-12 col-sm-6">
                            <div class="form-group">';
        echo $registerIndex['formReady']['lastname'][0];
        echo $registerIndex['formReady']['lastname'][1];
        echo '</div>
                   </div>';
        echo '<div class="col-12">
                            <div class="form-group">';
        echo $registerIndex['formReady']['user_email'][0];
        echo $registerIndex['formReady']['user_email'][1];
        echo '</div>
                   </div>';
        echo '<div class="col-12 col-sm-6">
                            <div class="form-group">';
        echo $registerIndex['formReady']['user_password'][0];
        echo $registerIndex['formReady']['user_password'][1];
        echo '</div>
                   </div>';
        echo '<div class="col-12 col-sm-6">
                            <div class="form-group">';
        echo $registerIndex['formReady']['user_password_confirm'][0];
        echo $registerIndex['formReady']['user_password_confirm'][1];
        echo '</div>
                   </div>';
        if (isset($validation)):
            echo '<div class="col-12">
                        <div class="alert alert-danger" role="alert">' .
                $validation->listErrors()
                . '</div>
                    </div>';
        endif;

        echo '</div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">' . lang('View.register.index.register') . '</button>
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <a href="/users/login">' . lang('View.register.index.haveAccount') . '</a>
                        </div>
                    </div>';
        if (!empty($registerIndex['captcha_site_key'])) {
            echo '<div class="row mt-5">
                        <div class="col-12 col-sm-4">
                            <div class="g-recaptcha" data-sitekey="' . $registerIndex['captcha_site_key'] . '"></div>
                        </div>
                    </div>';
        }else{
            // We can manipulate this when no have google key..
            echo '<input type="hidden" name="g-recaptcha-response" value="true">';
        }


        echo $registerIndex['form_close'];
    }


    ?>

</div>

<?php if (!empty($registerIndex['captcha_site_key'])) { ?>
    <script src='https://www.google.com/recaptcha/api.js?hl=tr'></script>
<?php } ?>


<script>

</script>