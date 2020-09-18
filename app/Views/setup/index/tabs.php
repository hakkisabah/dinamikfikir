<div class="row">
    <div class="col-md-12 mt-3 pt-3 pb-3 form-wrapper">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item col-md-offset-3 text-center" role="presentation">
                    <a class="nav-link active" id="veritabani-tab" data-toggle="tab" href="#veritabani" role="tab"
                       aria-controls="veritabani" aria-selected="true"><?php echo lang('View.setup.tabs.manuNames.database'); ?></a>
                </li>
                <li class="nav-item col-md-offset-3 text-center" role="presentation">
                    <a class="nav-link disabled" id="adminuser-tab" data-toggle="tab" href="#adminuser" role="tab"
                       aria-controls="adminuser" aria-selected="false"><?php echo lang('View.setup.tabs.manuNames.adminAccount'); ?></a>
                </li>
                <li class="nav-item col-md-offset-3 text-center" role="presentation">
                    <a class="nav-link disabled" id="mail-tab" data-toggle="tab" href="#mail" role="tab"
                       aria-controls="mail" aria-selected="false"><?php echo lang('View.setup.tabs.manuNames.mailSettings'); ?></a>
                </li>
                <li class="nav-item col-md-offset-3 text-center" role="presentation">
                    <a class="nav-link disabled" id="captcha-tab" data-toggle="tab" href="#captcha" role="tab"
                       aria-controls="captcha" aria-selected="false"><?php echo lang('View.setup.tabs.manuNames.captcha'); ?></a>
                </li>
                <li class="nav-item col-md-offset-3 text-center" role="presentation">
                    <a class="nav-link disabled" id="aws-tab" data-toggle="tab" href="#aws" role="tab"
                       aria-controls="aws" aria-selected="false"><?php echo lang('View.setup.tabs.manuNames.aws'); ?></a>
                </li>
            </ul>
            <?php echo view('setup/index/cards') ?>
        </div>
    </div>
</div>