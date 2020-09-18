<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <strong><?php echo lang('View.setup.color_info.titleColorFirst'); ?></strong> <?php echo lang('View.setup.color_info.titleColorLast'); ?>
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse col-md-12" aria-labelledby="headingOne"
             data-parent="#accordionExample">
            <div class="form-group row">
                <div class="col-md-3 mt-3 pt-3 pb-3 form-wrapper">
                    <div class="card-header bg-danger">
                        <div class="card-body text-center">
                            <p class="card-text"><?php echo lang('View.setup.color_info.beMust'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-3 pt-3 pb-3 form-wrapper">
                    <div class="card-header bg-warning">
                        <div class="card-body text-center">
                            <p class="card-text"><?php echo lang('View.setup.color_info.beRequired'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-3 pt-3 pb-3 form-wrapper">
                    <div class="card-header bg-info">
                        <div class="card-body text-center">
                            <p class="card-text"><?php echo lang('View.setup.color_info.fastSystem'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-3 pt-3 pb-3 form-wrapper">
                    <div class="card-header bg-secondary">
                        <div class="card-body text-center">
                            <p class="card-text"><?php echo lang('View.setup.color_info.lowModerate'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
