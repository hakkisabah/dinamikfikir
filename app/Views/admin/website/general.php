<div class="row">
    <div class="col-12 col-sm-6">
        <h4><?php echo lang('View.AdminPanel.general.generalSettings'); ?></h4>
    </div>
</div>
<hr>

<form id="siteConf">
    <div class="form-group row">
        <div class="col-md-6">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.general.siteName'); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" id="site_name" name="site_name"
                   class="form-control" onkeyup="formCollector(this)"
                   value="<?php echo $admin_site_data['site_general']['site_name'] ?>"/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.general.app_baseURL'); ?></label>
        </div>
        <div class="col-md-6">
            <input type="text" id="app_baseURL" name="app_baseURL"
                   class="form-control" onkeyup="formCollector(this)"
                   value="<?php echo getenv('app.baseURL') ?>"/>
        </div>
    </div>
    <?php
    $awsStatus = new AwsS3();
    $isAwsEnabled = $awsStatus->checkAWSaccountInfo();
    unset($awsStatus);
    if ($isAwsEnabled !== false) { ?>
        <div class="row col-md-offset-12 text-center m-auto">
            <div class="border border-warning p-2">
                <div class="form-group">
                    <div class="col-md-12">
                    <span><?php echo lang('View.AdminPanel.general.awsWarning'); ?>
                        </span>
                    </div>
                    <div id="locationInformer" class="d-none col-md-12 border border-dark">
                        <span><?php echo lang('View.AdminPanel.general.awsWarningUp'); ?></span>
                        <div id="locationSecond"></div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-6">
                        <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.general.uploadLocation'); ?></label>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="display:inline-block;max-width:90%;">
                            <select id="locationPrepare" class="custom-select" name="site_upload_location" onmouseup="formCollector(this)"
                                    style="width: 100%;">
                                <option value="LOCAL" <?= $admin_site_data['site_general']['site_upload_location'] == 'LOCAL' ? 'selected' : ''; ?>>
                                    <?php echo lang('View.AdminPanel.general.selectNameLocal'); ?>
                                </option>
                                <?php if ($admin_site_data['aws_system'] == 'ON') { ?>
                                    <option value="AWS" <?= $admin_site_data['site_general']['site_upload_location'] == 'AWS' ? 'selected' : ''; ?>>
                                        <?php echo lang('View.AdminPanel.general.selectNameAWS'); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row mt-4">
            <div class="col-sm-6">
                <label class="col-md-6 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.general.uploadLocation'); ?></label>
            </div>
            <div class="col-md-6">
                <div class="form-group" style="display:inline-block;max-width:90%;">
                    <select class="custom-select" name="site_upload_location" onmouseup="formCollector(this)"
                            style="width: 100%;">
                        <option value="LOCAL" <?= $admin_site_data['site_general']['site_upload_location'] == 'LOCAL' ? 'selected' : ''; ?>>
                            <?php echo lang('View.AdminPanel.general.selectNameLocal'); ?>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    <?php } ?>
</form>