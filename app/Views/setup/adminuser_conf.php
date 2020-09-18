<!--YONETICI HESABI  AYARLARI BURADAN İTİBAREN-->
<div class="row">
    <div class="col-md-6 mt-4">
        <h4><?php echo lang('View.setup.tabs.manuNames.adminAccount'); ?></h4>
    </div>
</div>
<hr>
<div id="adminusercard" class="form-group card">
    <div class="card-header bg-danger">
        <?php echo lang('View.setup.adminUserConf.adminCardLabel'); ?>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php echo lang('View.setup.adminUserConf.adminInfoLabel'); ?></h5>
        <p class="card-text"><?php echo lang('View.setup.adminUserConf.adminExplanation'); ?></p>
    </div>
</div>
<form id="adminUserConfForSetup">
    <?= helper(['form']) ?>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.setup.adminUserConf.userName'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.adminUserConf.userNamePlaceHolder'); ?>" type="text" id="user_name"
                       onkeyup="formCollector(this)"
                       name="user_name"
                       class="form-control"
                       value="admin"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.setup.adminUserConf.mailAddress'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.adminUserConf.mailAddressPlaceHolder'); ?>" type="email" id="user_email"
                       onkeyup="formCollector(this)"
                       name="user_email"
                       class="form-control"
                       value="<?= set_value('user_email'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.setup.adminUserConf.userPass'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.adminUserConf.userPassPlaceHolder'); ?>" type="password" id="user_password"
                       onkeyup="formCollector(this)"
                       name="user_password"
                       class="form-control"
                       value="<?= set_value('user_password'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.setup.adminUserConf.userPassConfrim'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.adminUserConf.userPassConfrimPlaceHolder'); ?>" type="password" id="user_password_confirm"
                       onkeyup="formCollector(this)"
                       name="user_password_confirm"
                       class="form-control"
                       value="<?= set_value('user_password_confirm'); ?>"/>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <a id="createAdminButton" class="btn btn-primary" onclick="createAdminForSetup()" role="button"><?php echo lang('View.setup.adminUserConf.create'); ?></a>
        </div>
    </div>
</form>
<hr>
<!--YONETICI HESABI AYARLARI BURADA BİTMİŞ OLACAK-->