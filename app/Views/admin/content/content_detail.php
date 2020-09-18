<div class="row">
    <div class="col-12 col-sm-6">
        <h4><?php echo lang('View.AdminPanel.content.detail.detailHeader'); ?></h4>
    </div>
</div>
<hr>
<form id="contentConf">
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.content.detail.contentDeleteLabel'); ?></label>
        <div class="col-md-6">
            <input class="btn btn-primary col-md-12" id="contentDeleteButton" role="button"  onclick="contentDetailProcess(this)"
                   value="<?php echo lang('View.AdminPanel.content.detail.contentDeleteButton'); ?>" disabled/>
            <input id="content_id" type="hidden" name="content_id" value="">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.content.detail.viewContentLabel'); ?></label>
        <div class="col-md-6">
            <button class="btn btn-primary col-md-12" id="contentShowButton" role="button" onclick="contentDetailProcess(this);return false" disabled>
                <?php echo lang('View.AdminPanel.content.detail.viewContentButton'); ?>
            </button>
            <input id="slug" type="hidden" name="slug" value="">
        </div>
    </div>
    <div class="form-group row">
        <img class="col-md-6 fade" id="userIcon" src="" alt="" width="48" height="48">
        <input type="hidden" id="icon_name" name="icon_name" value="">
        <div class="col-md-6">
            <button class="btn btn-primary col-md-12" id="usertShowButton" role="button" onclick="contentDetailProcess(this);return false" disabled>
                <?php echo lang('View.AdminPanel.content.detail.displayProfileButton'); ?>
            </button>
            <input type="hidden" id="user_name" name="user_name" value="">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.content.detail.contentTitleName'); ?></label>
        <div class="col-md-12">
            <input type="text" id="title" name="title"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>

</form>
