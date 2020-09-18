<div class="row">
    <div class="col-12 col-sm-6">
        <h4><?php echo lang('View.AdminPanel.users.searchTitle'); ?></h4>
    </div>
</div>
<hr>
<form id="userSearch">
    <div class="form-group row">
            <label class="col-md-6"><?php echo lang('View.AdminPanel.users.writeUserName'); ?></label>
        <div class="col-md-6">
            <input type="text" id="searchuser" name="searchuser"
                   class="form-control" onkeyup="userSearcher(this)"
                   value=""
                    autocomplete="off"/>
            <ul class="list-group" id="myList">
            </ul>
        </div>
    </div>
</form>
<div id="userError" class="form-group">

</div>