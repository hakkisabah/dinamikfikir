<div class="row">
    <div class="col-md-6 mt-4">
        <h4><?php echo lang('View.AdminPanel.imageLocationConf.imageLocation'); ?></h4>
    </div>
    <div class="col-md-6 mt-4 text-right">
        <a class="btn btn-primary" onclick="togglingShow(this)" data-toggle="collapse" href="#imageConf"
           role="button"
           aria-expanded="false" aria-controls="imageConf"><?php echo lang('View.AdminPanel.imageLocationConf.show'); ?></a>
    </div>
</div>
<hr>
<form id="imageConf" class="collapse">
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.imageLocationConf.imageMainPath'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" id="image_folder_base" onkeyup="formCollector(this)" name="image_folder_base"
                       class="form-control"
                       value="<?php echo $admin_site_data['image_location']['image_folder_base'] ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.imageLocationConf.realImagePath'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" id="real_image_folder" onkeyup="formCollector(this)" name="real_image_folder"
                       class="form-control"
                       value="<?php echo $admin_site_data['image_location']['real_image_folder'] ?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.imageLocationConf.iconImagePath'); ?></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" id="icon_base_folder" onkeyup="formCollector(this)" name="icon_base_folder"
                       class="form-control"
                       value="<?php echo $admin_site_data['image_location']['icon_base_folder'] ?>"/>
            </div>
        </div>
    </div>
</form>