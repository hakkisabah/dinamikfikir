<!--CAPTCHA AYARLARI BURADAN İTİBAREN-->
    <div class="row">
        <div class="col-md-6 mt-4">
            <h4><?php echo lang('View.AdminPanel.captchaConf.captchaSystem'); ?></h4>
        </div>
        <div class="col-md-6 mt-4 text-right">
            <a class="btn btn-primary" onclick="togglingShow(this)" data-toggle="collapse" href="#catpchaConf"
               role="button"
               aria-expanded="false" aria-controls="catpchaConf"><?php echo lang('View.AdminPanel.captchaConf.show'); ?></a>
        </div>
    </div>
    <hr>
    <form id="catpchaConf" class="collapse">
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.captchaConf.secretKey'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.captchaConf.secretKeyPlaceHolder'); ?>" type="text" id="captcha_secret_key" onkeyup="formCollector(this)" name="captcha_secret_key"
                           class="form-control"
                           value="<?php echo $admin_site_data['google_captcha']['captcha_secret_key'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.captchaConf.siteKey'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.captchaConf.siteKeyPlaceHolder'); ?>" type="text" id="capctcha_site_key" onkeyup="formCollector(this)" name="capctcha_site_key"
                           class="form-control"
                           value="<?php echo $admin_site_data['google_captcha']['capctcha_site_key'] ?>"/>
                </div>
            </div>
        </div>
    </form>
    <!--CAPTCHA AYARLARI BURADA BİTMİŞ OLACAK-->