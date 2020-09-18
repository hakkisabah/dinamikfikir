<div class="row">
    <div class="col-12 mt-4">
        <h4><?php echo lang('View.setup.tabs.manuNames.captcha'); ?></h4>
    </div>
</div>
<hr>
<div id="captchacard" class="form-group card">
    <div class="card-header bg-warning">
        <?php echo lang('View.setup.capctchaConf.captchaCardLabel'); ?>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php echo lang('View.setup.capctchaConf.captchaInfoLabel'); ?></h5>
        <p class="card-text"><?php echo lang('View.setup.capctchaConf.captchaExplanation'); ?></p>
    </div>
</div>
<form id="captchaForSetup">
    <div class="form-group row">
        <div class="col-md-6">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.captchaConf.secretKey'); ?></label>
        </div>
        <div class="col-md-6">
            <input placeholder="<?php echo lang('View.AdminPanel.captchaConf.secretKeyPlaceHolder'); ?>" type="text" id="captcha_secret_key"
                   name="captcha_secret_key"
                   class="form-control" onkeyup="formCollector(this)"
                   value=""/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.captchaConf.siteKey'); ?></label>
        </div>
        <div class="col-md-6">
            <input placeholder="<?php echo lang('View.AdminPanel.captchaConf.siteKeyPlaceHolder'); ?>" type="text" id="capctcha_site_key" name="capctcha_site_key"
                   class="form-control" onkeyup="formCollector(this)"
                   value=""/>
        </div>
    </div>
</form>