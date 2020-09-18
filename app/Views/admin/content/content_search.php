<div class="row">
    <div class="col-12 col-sm-6">
        <h4><?php echo lang('View.AdminPanel.content.search.searchHeader');?></h4>
    </div>
</div>
<hr>
<form id="contentSearch">
    <div class="form-group row">
        <label class="col-md-6"><?php echo lang('View.AdminPanel.content.search.searchBoxLabel'); ?></label>
        <div class="col-md-6">
            <input type="text" id="searchcontent" name="searchcontent"
                   class="form-control" onkeyup="contentSearcher(this)"
                   value=""
                   autocomplete="off"/>
            <ul class="list-group" id="myContentList">
            </ul>
        </div>
    </div>
</form>
<div id="contentError" class="form-group">

</div>