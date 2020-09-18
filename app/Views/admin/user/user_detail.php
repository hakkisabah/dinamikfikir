<div class="row">
    <div class="col-12 col-sm-6">
        <h4><?php echo lang('View.AdminPanel.users.detail.title'); ?></h4>
    </div>
</div>
<hr>
<form id="userConf">
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.suspendUser'); ?></label>
        <div class="col-sm-5" id="suspendedMainDiv">
            <button type="button" id="suspendedForButton" onclick="suspendswitcher('suspended')" class="btn btn-toggle"
                    data-toggle="button"
                    aria-pressed="false"
                    autocomplete="off" disabled>
                <div class="handle"></div>
                <input type="hidden" id="suspended" name="suspended"
                       value="0">
            </button>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.sendActivationMail'); ?></label>
        <div class="col-md-12">
            <input class="btn btn-primary col-md-12" id="reActivationButton" role="button" onclick="reActivation()" value="<?php echo lang('View.AdminPanel.users.detail.sendCode'); ?>" disabled/>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.userId'); ?></label>
        <div class="col-md-12">
            <input type="text" id="user_id" name="user_id"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.userName'); ?></label>
        <div class="col-md-12">
            <input type="text" id="user_name" name="user_name"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.firstName'); ?></label>
        <div class="col-md-12">
            <input type="text" id="firstname" onkeyup="formCollector(this)" name="firstname"
                   class="form-control"
                   value=""/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.lastName'); ?></label>
        <div class="col-md-12">
            <input type="text" id="lastname" onkeyup="formCollector(this)" name="lastname"
                   class="form-control"
                   value=""/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.userMail'); ?></label>
        <div class="col-md-12">
            <input type="text" id="user_email" onkeyup="formCollector(this)" name="user_email"
                   class="form-control"
                   value=""/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.userLastLoginDate'); ?></label>
        <div class="col-md-12">
            <input type="text" id="last_login_date" name="last_login_date"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-12"><?php echo lang('View.AdminPanel.users.detail.emailStatus'); ?></label>
        <div class="col-md-12">
            <input type="text" id="email_status" name="email_status"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.setPassForUser'); ?></label>
        <div class="col-md-12">
            <input placeholder="<?php echo lang('View.AdminPanel.users.detail.setPassForUserPlaceHolder'); ?>" type="text" id="user_password"
                   onkeyup="formCollector(this)" name="user_password"
                   class="form-control"
                   value=""/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.userCurrentIcon'); ?></label>
        <div class="col-md-12">
            <input type="text" id="icon_name" name="icon_name"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.users.detail.userRole'); ?></label>
        <div class="col-md-12">
            <input type="text" id="role" name="role"
                   class="form-control"
                   value="" disabled/>
        </div>
    </div>

</form>