<!--VERİTABANI AYARLARI BURADAN İTİBAREN-->
<div class="row">
    <div class="col-md-6 mt-4">
        <h4><?php echo lang('View.setup.tabs.manuNames.database'); ?></h4>
    </div>
</div>
<hr>
<div id="veritabanicard" class="form-group card">
    <div class="card-header bg-danger">
        <?php echo lang('View.setup.databaseConf.databaseCardLabel'); ?>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php echo lang('View.setup.databaseConf.databaseInfoLabel'); ?></h5>
        <p class="card-text"><?php echo lang('View.setup.databaseConf.databaseExplanation'); ?></p>
    </div>
</div>
<form id="dbConfForSetup">
    <?= helper(['form']) ?>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.setup.databaseConf.target'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.databaseConf.targetPlaceHolder'); ?>" type="text" id="hostname"
                       onkeyup="formCollector(this)"
                       name="hostname"
                       class="form-control"
                       value="<?= set_value('hostname'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.setup.databaseConf.userName'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.databaseConf.userNamePlaceHolder'); ?>" type="text" id="username"
                       onkeyup="formCollector(this)"
                       name="username"
                       class="form-control"
                       value="<?= set_value('username'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.setup.databaseConf.pass'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.databaseConf.passPlaceHolder'); ?>" type="text" id="password"
                       onkeyup="formCollector(this)"
                       name="password"
                       class="form-control"
                       value="<?= set_value('password'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.setup.databaseConf.databaseName'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input placeholder="<?php echo lang('View.setup.databaseConf.databaseNamePlaceHolder'); ?>" type="text" id="database"
                       onkeyup="formCollector(this)"
                       name="database"
                       class="form-control"
                       value="<?= set_value('database'); ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-md-6 col-form-label col-form-label-sm">Veri tabanı sürücüsü</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" id="DBDriver"
                       onkeyup="formCollector(this)"
                       name="DBDriver"
                       class="form-control"
                       value="MySQLi" disabled/>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-right">
        <a class="btn btn-primary" onclick="testDbForSetup()" role="button"><?php echo lang('View.setup.databaseConf.test'); ?></a>
    </div>
</form>
<hr>
<!--VERİTABANI AYARLARI BURADA BİTMİŞ OLACAK-->