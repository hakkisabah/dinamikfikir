<!--MAİL AYARLARI BURADAN İTİBAREN-->
    <div class="row">
        <div class="col-md-6">
            <h4><?php echo lang('View.AdminPanel.mailConf.mailSystem'); ?></h4>
        </div>
        <div class="col-md-6 text-right">
            <a class="btn btn-primary" onclick="togglingShow(this)" data-toggle="collapse" href="#mailConf"
               role="button"
               aria-expanded="false" aria-controls="mailConf"><?php echo lang('View.AdminPanel.mailConf.show'); ?></a>
        </div>
    </div>
    <hr>
    <form id="mailConf" class="collapse">
        <?= helper(['form']) ?>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailProvider'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.mailProviderPlaceHolder'); ?>" type="text" id="mail_smtp_host" onkeyup="formCollector(this)"
                           name="mail_smtp_host"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['user']['mail_smtp_host'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailUser'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.mailUserPlaceHolder'); ?>" type="text" id="mail_smtp_user" onkeyup="formCollector(this)"
                           name="mail_smtp_user"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['user']['mail_smtp_user'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.userPass'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.userPassPlaceHolder'); ?>" type="text" id="mail_smtp_pass" onkeyup="formCollector(this)"
                           name="mail_smtp_pass"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['user']['mail_smtp_pass'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailPort'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.mailPortPlaceHolder'); ?>" type="text" id="mail_smtp_port" onkeyup="formCollector(this)"
                           name="mail_smtp_port"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['user']['mail_smtp_port'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row pl-3">
            <div class="col-md-8">
                <label class="col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.testMailLabel'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.testMailPlaceHolder'); ?>" type="text" id="test_mail_input" onkeyup="formCollector(this)"
                           name="test_mail_input"
                           class="form-control"/>
                </div>

            </div>
            <div class="col-md-4 text-right">
                <a class="btn btn-primary" onclick="testMail()" role="button"><?php echo lang('View.AdminPanel.mailConf.testMailTestButton'); ?></a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.protocol'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.protocolPlaceHolder'); ?>" type="text" id="mail_protocol" onkeyup="formCollector(this)" name="mail_protocol"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['system']['mail_protocol'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.senderPath'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input type="text" id="mail_path" onkeyup="formCollector(this)" name="mail_path"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['system']['mail_path'] ?>"
                           disabled/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.charSet'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.charSetPlaceHolder'); ?>" type="text" id="mail_charset" onkeyup="formCollector(this)" name="mail_charset"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['system']['mail_charset'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.wordWrap'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group" style="display:inline-block;max-width:90%;">
                    <select class="custom-select" name="mail_wordwrap" onmouseup="formCollector(this)"
                            style="width: 100%;">
                        <option value="true" <?= $admin_site_data['mail_config']['system']['mail_wordwrap'] == 'true' ? 'selected' : ''; ?>>
                            <?php echo lang('View.AdminPanel.mailConf.wordWrapOn'); ?>
                        </option>
                        <option value="false" <?= $admin_site_data['mail_config']['system']['mail_wordwrap'] == 'false' ? 'selected' : ''; ?>>
                            <?php echo lang('View.AdminPanel.mailConf.wordWrapOff'); ?>
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.priority'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group" style="display:inline-block;max-width:90%;">
                    <select class="custom-select" name="mail_priority" onmouseup="formCollector(this)"
                            style="width: 100%;">
                        <?php
                        $priority = 5;
                        for ($i = 1; $i <= $priority; $i++) {
                            if ($admin_site_data['mail_config']['system']['mail_priority'] == $i) {
                                echo '
                                <option value="'
                                    . $admin_site_data['mail_config']['system']['mail_priority'] . '" selected>'
                                    . $admin_site_data['mail_config']['system']['mail_priority']
                                    . '</option>';
                            } else {
                                echo '
                             <option value="' . $i . '">' .
                                    $i
                                    . '</option>';
                            }

                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.activationSegment'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input placeholder="<?php echo lang('View.AdminPanel.mailConf.activationSegmentPlaceHolder'); ?>" type="text" id="activationEndpoint" onkeyup="formCollector(this)"
                           name="email_activation_endpoint"
                           class="form-control"
                           value="<?php echo $admin_site_data['mail_config']['system']['email_activation_endpoint'] ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.activationMailAddress'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input type="text" id="mail_from" onkeyup="formCollector(this)" name="mail_from"
                           class="form-control"
                           value="<?php echo getenv('MAIL_SMTPUSER') ?>" disabled/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.mailName'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input type="text" id="mail_name" onkeyup="formCollector(this)" name="mail_name"
                           class="form-control"
                           value="<?php echo lang('View.setup.defaultMailEnv.MAIL_NAME'); ?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="col-sm-2 col-form-label col-form-label-sm"><?php echo lang('View.AdminPanel.mailConf.subject'); ?></label>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <input type="text" id="mail_default_subject" onkeyup="formCollector(this)"
                           name="mail_default_subject"
                           class="form-control"
                           value="<?php echo lang('View.setup.defaultMailEnv.MAIL_DEFAULT_SUBJECT'); ?>"/>
                </div>
            </div>
        </div>

    </form>
    <!--MAİL AYARLARI BURADA BİTMİŞ OLACAK-->