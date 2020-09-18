<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="veritabani" role="tabpanel"
         aria-labelledby="veritabani-tab">
        <?php
        echo view('setup/database');
        ?>
    </div>
    <div class="tab-pane fade" id="adminuser" role="tabpanel" aria-labelledby="adminuser-tab">
        <?php
        echo view('setup/adminuser_conf');
        ?>
    </div>
    <div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-tab">
        <?php
        echo view('setup/mail_conf');
        ?>
    </div>
    <div class="tab-pane fade" id="captcha" role="tabpanel" aria-labelledby="captcha-tab">
        <?php
        echo view('setup/captcha');
        ?>
    </div>
    <div class="tab-pane fade" id="aws" role="tabpanel" aria-labelledby="aws-tab">
        <?php
        echo view('setup/aws_system');
        ?>
    </div>
</div>