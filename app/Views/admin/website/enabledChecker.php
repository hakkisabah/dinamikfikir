<div class="row">
    <div class="col-12 col-sm-6 mt-3">
        <h4><?php echo lang('View.AdminPanel.enabledChecker.logSettings'); ?></h4>
    </div>
</div>
<hr>
<form id="enabledConf">
    <?= helper(['form']) ?>
    <div class="row">
        <div class="col-sm-2">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.enabledChecker.file'); ?></label>
        </div>
        <div class="col-sm-5">
            <button type="button" onclick="logswitcher('FILELOG')" class="btn btn-toggle"
                    data-toggle="button"
                    aria-pressed="<?= !empty($admin_site_data['logger']['file']) && $admin_site_data['logger']['file'] == 'ON' ? 'true' : 'false' ?>"
                    autocomplete="off">
                <div class="handle"></div>
                <input type="hidden" id="FILELOG" name="file"
                       value="<?=  $admin_site_data['logger']['file']; ?>">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.enabledChecker.sql'); ?></label>
        </div>
        <div class="col-sm-5">
            <button type="button" onclick="logswitcher('DBLOG')" class="btn btn-toggle" data-toggle="button"
                    aria-pressed="<?= !empty($admin_site_data['logger']['db']) && $admin_site_data['logger']['db'] == 'ON' ? 'true' : 'false' ?>"
                    autocomplete="off">
                <div class="handle"></div>
                <input type="hidden" id="DBLOG" name="db"
                       value="<?= $admin_site_data['logger']['db'] ?>">
            </button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-sm-6">
            <h4><?php echo lang('View.AdminPanel.enabledChecker.mailSettings'); ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.enabledChecker.system'); ?></label>
        </div>
        <div class="col-sm-5">
            <button type="button" onclick="logswitcher('MAIL_SYSTEM')" class="btn btn-toggle"
                    data-toggle="button"
                    aria-pressed="<?= !empty($admin_site_data['mail_system']) && $admin_site_data['mail_system'] == 'ON' ? 'true' : 'false' ?>"
                    autocomplete="off">
                <div class="handle"></div>
                <input type="hidden" id="MAIL_SYSTEM" name="mail_system"
                       value="<?= getenv('MAIL_SYSTEM') != 'ON'?'OFF':'ON'?>">
            </button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-sm-6">
            <h4><?php echo lang('View.AdminPanel.enabledChecker.awsSettings'); ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.enabledChecker.system'); ?></label>
        </div>
        <div class="col-sm-5">
            <button type="button" onclick="" class=" btn-toggle disabled"
                    data-toggle="button"
                    aria-pressed="<?= $admin_site_data['site_general']['site_upload_location'] != 'LOCAL' ? 'true' : 'false' ?>"
                    autocomplete="off">
                <div class="handle"></div>
                <input type="hidden" id="aws_system" name="aws_system"
                       value="<?= $admin_site_data['aws_system'] ?>">
            </button>
        </div>
    </div>
</form>
