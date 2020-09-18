<!--MAİL AYARLARI BURADAN İTİBAREN-->
<div class="row">
    <div class="col-md-6 mt-4">
        <h4><?php echo lang('View.setup.tabs.manuNames.mailSettings'); ?></h4>
    </div>
    <div class="col-md-6 mt-4 text-right">
        <a class="btn btn-primary" onclick="togglingShow(this)" data-toggle="collapse" href="#mailConfForSetup"
           role="button" aria-expanded="false" aria-controls="mailConfForSetup"><?php echo lang('View.setup.mailConf.show'); ?></a>
    </div>
</div>
<hr>
<div id="mailcard" class="form-group card">
    <div class="card-header bg-warning">
        <?php echo lang('View.setup.mailConf.mailCardLabel'); ?>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php echo lang('View.setup.mailConf.mailInfoLabel'); ?></h5>
        <p class="card-text"><?php echo lang('View.setup.mailConf.mailExplanation'); ?></p>
    </div>
</div>
<form id="mailConfForSetup" class="collapse">
    <?= helper(['form']) ?>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailProvider'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.AdminPanel.mailConf.mailProviderPlaceHolder'); ?>" type="text" id="mail_smtp_host" onkeyup="formCollector(this)"
                       name="mail_smtp_host"
                       class="form-control"
                       value="<?= set_value('mail_smtp_host'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailUser'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.AdminPanel.mailConf.mailUserPlaceHolder'); ?>" type="text" id="mail_smtp_user" onkeyup="formCollector(this)"
                       name="mail_smtp_user"
                       class="form-control"
                       value="<?= set_value('mail_smtp_user'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.userPass'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.AdminPanel.mailConf.userPassPlaceHolder'); ?>" type="text" id="mail_smtp_pass" onkeyup="formCollector(this)"
                       name="mail_smtp_pass"
                       class="form-control"
                       value="<?= set_value('mail_smtp_pass'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailPort'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.AdminPanel.mailConf.mailPortPlaceHolder'); ?>" type="text" id="mail_smtp_port" onkeyup="formCollector(this)"
                       name="mail_smtp_port"
                       class="form-control"
                       value="587"/>
            </div>
        </div>
    </div>
    <div class="row pl-3">
        <div class="col-md-8">
            <label class="col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.testMailLabel'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.AdminPanel.mailConf.testMailPlaceHolder'); ?>" type="text" id="test_mail_input" onkeyup="formCollector(this)"
                       name="test_mail_input"
                       class="form-control" value="<?= set_value('test_mail_input') ?>"/>
            </div>
        </div>
        <div class="col-md-4 text-right">
            <a class="btn btn-primary" onclick="testMailForSetup()" role="button"><?php echo lang('View.AdminPanel.mailConf.testMailTestButton'); ?></a>
        </div>
    </div>
    <hr>
</form>
<!--MAİL AYARLARI BURADA BİTMİŞ OLACAK-->