<!--AWS AYARLARI BURADAN İTİBAREN-->
    <div class="row">
        <div class="col-md-6 mt-4">
            <h4><?php echo lang('View.AdminPanel.awsConf.awsSystem'); ?></h4>
        </div>
        <div class="col-md-6 mt-4 text-right">
            <a class="btn btn-primary" onclick="togglingShow(this)" data-toggle="collapse" href="#awsConf"
               role="button"
               aria-expanded="false" aria-controls="awsConf"><?php echo lang('View.AdminPanel.awsConf.show'); ?></a>
        </div>
    </div>
    <hr>
    <form id="awsConf" class="collapse">
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.awsConf.serverRegion'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.awsConf.serverRegionPlaceHolder'); ?>" type="text" id="aws_region" onmouseup="formCollector(this)" onkeyup="formCollector(this)" name="aws_region"
                           class="form-control"
                           value="<?php echo $admin_site_data['aws_config']['aws_region'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.awsConf.accessKey'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.awsConf.accessKeyPlaceHolder'); ?>" type="text" id="aws_acceskeyid" onmouseup="formCollector(this)" onkeyup="formCollector(this)" name="aws_acceskeyid"
                           class="form-control"
                           value="<?php echo $admin_site_data['aws_config']['aws_acceskeyid'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.awsConf.secretKey'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.awsConf.secretKeyPlaceHolder'); ?>" type="text" id="aws_secretkey" onkeyup="formCollector(this)" name="aws_secretkey"
                           class="form-control"
                           value="<?php echo $admin_site_data['aws_config']['aws_secretkey'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.awsConf.bucketName'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.awsConf.bucketNamePlaceHolder'); ?>" type="text" id="aws_bucketname" onkeyup="formCollector(this)" name="aws_bucketname"
                           class="form-control"
                           value="<?php echo $admin_site_data['aws_config']['aws_bucketname'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-4 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.awsConf.publicAddress'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.awsConf.publicAddressPlaceHolder'); ?>" type="text" id="aws_remotepublicaddress" onkeyup="formCollector(this)" name="aws_remotepublicaddress"
                           class="form-control"
                           value="<?php echo $admin_site_data['aws_config']['aws_remotepublicaddress'] ?>"/>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <span id="awsspinner" class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                <a id="awsButton" class="btn btn-primary" onclick="testAws(this)" role="button"><?php echo lang('View.AdminPanel.website.awsTestButtonElementTextContextForNormal'); ?></a>
            </div>
        </div>
    </form>
    <!--AWS AYARLARI BURADA BİTMİŞ OLACAK-->


