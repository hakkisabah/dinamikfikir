<?php
if (!empty($admin_site_data)) {
    $data['admin_site_data'] = $admin_site_data;
    ?>
    <link href="<?= $data['admin_site_data']['cssTarget'] ?>" rel="stylesheet" type="text/css"/>
    <div class="row">
        <?php if (session()->get('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('success') ?>
            </div>
        <?php endif; ?>

        <div class="col-lg-6 mt-3 pt-3 pb-3 form-wrapper">
            <div class="container">
                <?php
                echo view('admin/website/general', $data);
                echo view('admin/website/enabledChecker', $data);
                ?>
            </div>
        </div>
        <div class="col-lg-6 mt-3 pt-3 pb-3 form-wrapper">
            <div class="container">
                <?php
                echo view('admin/website/mail_conf', $data);
                echo view('admin/website/aws_conf', $data);
                echo view('admin/website/captcha', $data);
                echo view('admin/website/image_location', $data);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 ">
            <div class="container">
                <div class="col-md-12 text-right">
                    <a class="btn btn-primary" style=" position: fixed;
    bottom: 50px;
    left: 10px; " onclick="updateSiteConf()" role="button"><?php echo lang('View.AdminPanel.website.update');?></a>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    echo lang('View.AdminPanel.website.data_error');
} ?>
<script>

    let forms = {}

    let timeLeft = 10;

    // countdown => https://codepen.io/joshua-golub/pen/LYYKrKg
    function countdown() {
        timeLeft--;
        document.getElementById("locationSecond").innerHTML = String( timeLeft );
        if (timeLeft > 0) {
            setTimeout(countdown, 1000);
        }else{
            let informer = document.getElementById("locationInformer");
            informer.setAttribute('class',informer.getAttribute('class').replace('',' d-none '))
            timeLeft = 10
            requestDynamic('/admin/locationsuspend', 'locationwait=0')
                .then(function (res) {
                    location.reload()
                }).catch(function (e) {
                console.log('hata')
                console.log(e)
            })
        }
    };
    function formCollector(element) {
        if (element.id == 'locationPrepare' && timeLeft >=10){
            let informer = document.getElementById('locationInformer')
            informer.setAttribute('class',informer.getAttribute('class').replace('d-none',''))
            requestDynamic('/admin/locationsuspend', 'locationwait=1')
                .then(function (res) {

                }).catch(function (e) {
                console.log('hata')
                console.log(e)
            })
            setTimeout(countdown, 1000);
        }
        forms[element.name] = element.value
    }
    function testMail() {
        let formData = new FormData();
        let testMailAddress = document.getElementById('test_mail_input').value
        formData.append('test_mail_input', testMailAddress)
        requestDynamic('/admin/testmail', formData)
            .then(function (res) {
                 alert(testMailAddress + " " +"<?php echo lang('View.AdminPanel.website.ajax_mail_succes'); ?>")
            }).catch(function (e) {
            console.log(e)
            alert(testMailAddress + " " +"<?php echo lang('View.AdminPanel.website.ajax_mail_succes'); ?>")
        })
    }
    function testAws(e) {
        let formData = new FormData();
        let aws_region = document.getElementById('aws_region').value
        let aws_acceskeyid = document.getElementById('aws_acceskeyid').value
        let aws_secretkey = document.getElementById('aws_secretkey').value
        let aws_bucketname = document.getElementById('aws_bucketname').value
        let aws_remotepublicaddress = document.getElementById('aws_remotepublicaddress').value
        formData.append('aws_region', aws_region)
        formData.append('aws_acceskeyid', aws_acceskeyid)
        formData.append('aws_secretkey', aws_secretkey)
        formData.append('aws_bucketname', aws_bucketname)
        formData.append('aws_remotepublicaddress', aws_remotepublicaddress)
        e.setAttribute('class',e.getAttribute('class').replace('',' disabled '))
        e.textContent = "<?php echo lang('View.AdminPanel.website.awsTestButtonElementTextContextForWait'); ?>"
        let awsSpinner = document.getElementById('awsspinner')
        awsSpinner.setAttribute('class',awsSpinner.getAttribute('class').replace(' d-none',''))
        requestDynamic('/admin/testaws', formData)
            .then(function (res) {
                // console.log(res)
                if (res.worked){
                    e.setAttribute('class',e.getAttribute('class').replace('disabled',''))
                    e.textContent = "<?php echo lang('View.AdminPanel.website.awsTestButtonElementTextContextForNormal'); ?>"
                    awsSpinner.setAttribute('class',awsSpinner.getAttribute('class').replace('',' d-none '))
                    alert("<?php echo lang('View.AdminPanel.website.awsTestResultSuccess'); ?>")
                }
            }).catch(function (e) {
            console.log(e)
            alert("<?php echo lang('View.AdminPanel.website.awsTestResultFail'); ?>")
        })
    }

    function updateSiteConf() {
        let formData = new FormData();
        Object.keys(forms).forEach(key => {
            formData.append(key.toString(), forms[key].toString())
        });
        requestDynamic('/admin/uploadsiteconf', formData)
            .then(function (res) {
                 location.reload()
            }).catch(function (e) {
            console.log('hata')
            console.log(e)
        })

    }

    function logswitcher(idName) {
        let log = document.getElementById(idName)
        log.value = log.value == 'ON' ? 'OFF' : 'ON'
        let logAttr = log.getAttribute('aria-pressed')
        log.setAttribute('aria-pressed', logAttr == 'true' ? 'false' : 'true')
        forms[log.name] = log.value
    }

    function togglingShow(e) {
        let logAttr = e.getAttribute('aria-expanded')
        e.textContent = logAttr == 'true' ? "<?php echo lang('View.AdminPanel.website.show'); ?>" : "<?php echo lang('View.AdminPanel.website.close'); ?>"
    }
</script>
