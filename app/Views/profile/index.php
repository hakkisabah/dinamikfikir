    <div class="row">
        <div class="col-12 col-sm8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 form-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3><?=isset($user['firstname']) ? set_value('firstname', $user['firstname']) . ' ' . set_value('lastname', $user['lastname']) : '' ?></h3>
                    </div>
                    <div class="col-12 col-sm-6 text-right">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#select-avatar">
                            <?php echo lang('View.profile.index.avatar'); ?>
                        </button>
                    </div>
                </div>
                <hr>
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="media">
                            <img id="avatarSourceLink" src="<?php
                            echo (new \App\Controllers\Extension\Icons())->IconBaseAddress . session()->get('userInfo')['icon_name']  ?>"
                                 class="mr-3" alt="...">
                        </div>
                    </div>
                </div>
                <form class="" action="/users/profile" method="post">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="firstname"><?php echo lang('View.profile.index.userName'); ?></label>
                                <input type="text" class="form-control" readonly name="user_name" id="user_name"
                                       value="<?= isset($user['user_name']) ? set_value('user_name', $user['user_name']) : '' ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="firstname"><?php echo lang('View.profile.index.firstName'); ?></label>
                                <input type="text" class="form-control" name="firstname" id="firstname"
                                       value="<?= isset($user['firstname']) ? set_value('firstname', $user['firstname']) : '' ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="lastname"><?php echo lang('View.profile.index.lastName'); ?></label>
                                <input type="text" class="form-control" name="lastname" id="lastname"
                                       value="<?= isset($user['lastname']) ? set_value('lastname', $user['lastname']) : '' ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_email"><?php echo lang('View.profile.index.mailAddress'); ?></label>
                                <input type="text" class="form-control" readonly id="email"
                                       value="<?= $user['user_email'] ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="user_password"><?php echo lang('View.profile.index.pass'); ?></label>
                                <input type="password" class="form-control" name="user_password" id="password" value="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="user_password_confirm"><?php echo lang('View.profile.index.passConfrim'); ?></label>
                                <input type="password" class="form-control" name="user_password_confirm"
                                       id="password_confirm" value="">
                            </div>
                        </div>
                        <input type="hidden" id="#selectedAvatar" name="selectedAvatar" value="">
                        <?php if (isset($validation)): ?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary"><?php echo lang('View.profile.index.update'); ?></button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
