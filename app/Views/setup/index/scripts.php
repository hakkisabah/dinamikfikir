<script src="public/assets/js/jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="public/assets/js/ajax/axios_dist_axios.js" type="text/javascript"></script>
<script>
    function lgLogic(lg, num) {
        if (num === 1 && lg == 'tr') {
            alert("<?php echo lang('View.shared.languageSameSelectWarning');  ?>")
            return false
        }
        if (num === 2 && lg == 'en') {
            alert("<?php echo lang('View.shared.languageSameSelectWarning');  ?>")
            return false
        }
        return true

    }

    function setLocale(langId) {
        let isConfirm = confirm("<?php echo lang('View.shared.languageWarning'); ?>")
        if (isConfirm == true) {
            let getCk = '<?php echo get_cookie('df_lang'); ?>';
            if (lgLogic(getCk, langId) == false) {
                return false
            }
            if (langId == 1) {
                document.cookie = "df_lang=tr";
            } else {

                document.cookie = "df_lang=en";

            }
            location.reload();
        }
    }
</script>

<script>

    // BURADAKİ TÜM JAVASCRIPT FONKSİYONLARI OLUŞABİLEŞECEK HERHANGİ BİR GÜVENLİK AÇIĞI SEBEBİYLE
    // BİLİNÇLİ BİR ŞEKİLDE DOSYAYA AKTARILMAMIŞTIR..

    //  -- VARIABLES --
    let forms = {}
    let isSetEnv = {
        db: 1,
        adminUser: 1,
        mail: 1,
        captcha: 1,
        aws: 1,
    }
    let breakFree = {
        aws: 0,
        mail: 0,
        captcha: 0,
    }
    //  -- VARIABLES END --

    // BASE REQUEST
    function requestDynamic(url, payload, cb) {
        return axios.post(url, payload)
            .then(function (res) {
                if (cb) {
                    return cb(res.data)
                } else {
                    return res.data
                }
            }).catch(function (e) {
                return e
            })
    }

    // BASE TEST REQUEST
    function testSender(endpoint, data, tabName, cb) {
        requestDynamic(endpoint, data)
            .then(function (res) {
                // console.log(res)
                // setuptan gelen worked çalışmasını istediğimiz alanın durumu bildirilir
                if (res.worked && !res.error) {
                    if (isSetEnv[res.name]) {
                        // işlem başarılı olduğu zaman alert ile bildilirilir
                        // bu işi bize responseSuccessMessager fonksiyonu sağlamaktadır.
                        responseSuccessMessager(res.name, tabName, res.worked)
                        if (cb) {
                            return cb(res)
                        } else {
                            return true
                        }
                    }
                } else {
                    if (res.name == 'adminUser') {
                        // validasyon işlemleri arka planda ve sadece yönetici hesabı oluşturulrken
                        // yapıldığından bununla ilgil bir hata olduğunda özellikle tespit edip oluşan hata mesajını gönderiyoruz.
                        showMessage(tabName, res.error)
                        if (cb) return cb(res)
                    } else {
                        // Diğer tüm hata türleri tek bir mesajda gösterilebilmektedir.
                        showMessage(tabName, '<p>' + cardIdTeller(tabName) + '<?php echo lang('View.setup.scripts.testSenderNotConfirm') ?>' + '</p>')
                        if (cb) return cb(res)
                    }
                }
            }).catch(function (e) {
            console.log('hata')
        })
    }

    // -- FORM FIELDS PREPARE AND SEND --

    // Buradaki bilgileri bir döngüye de sokabilirdik fakat bu sayfanın bir benzeri
    // admin panelinde mevcut ve bir takım döngüler ile ilerlemekte, bu kod blokları okundukça
    // ileriki adımlar daha iyi anlaşılacaktır..

    function testDbForSetup() {
        let formData = new FormData();
        let hostname = document.getElementById('hostname').value
        let username = document.getElementById('username').value
        let password = document.getElementById('password').value
        let database = document.getElementById('database').value
        let DBDriver = document.getElementById('DBDriver').value
        formData.append('hostname', hostname)
        formData.append('username', username)
        formData.append('password', password)
        formData.append('database', database)
        formData.append('DBDriver', DBDriver)
        testSender('/setup/testdbforsetup', formData, 'veritabanicard', resultCallbackReturner)

    }

    function createAdminForSetup() {
        let formData = new FormData();
        let user_name = document.getElementById('user_name').value
        let user_email = document.getElementById('user_email').value
        let user_password = document.getElementById('user_password').value
        let user_password_confirm = document.getElementById('user_password_confirm').value
        formData.append('user_name', user_name)
        formData.append('user_email', user_email)
        formData.append('user_password', user_password)
        formData.append('user_password_confirm', user_password_confirm)
        testSender('/setup/createadminforsetup', formData, 'adminusercard', resultCallbackReturner)
    }

    function testMailForSetup() {
        let formData = new FormData();
        let testMailAddress = document.getElementById('test_mail_input').value
        let testMailSmtpHost = document.getElementById('mail_smtp_host').value
        let testMailSmtpUser = document.getElementById('mail_smtp_user').value
        let testMailSmtpPass = document.getElementById('mail_smtp_pass').value
        let testMailSmtpPort = document.getElementById('mail_smtp_port').value
        formData.append('test_mail_input', testMailAddress)
        formData.append('mail_smtp_host', testMailSmtpHost)
        formData.append('mail_smtp_user', testMailSmtpUser)
        formData.append('mail_smtp_pass', testMailSmtpPass)
        formData.append('mail_smtp_port', testMailSmtpPort)
        testSender('/setup/testmailforsetup', formData, 'mailcard')
    }

    function awsButtonWaitEnderWhenResponse(e,awsSpinner){
        // Butonu bekletme işlemini 3 yerde kullandığımız için kod tekrarını ortadan kaldırmak adına
        // bu fonksiyon anlam kazanmaktadır.
        e.setAttribute('class', e.getAttribute('class').replace('disabled', ''))
        e.textContent = "<?php echo lang('View.AdminPanel.website.awsTestButtonElementTextContextForNormal'); ?>"
        awsSpinner.setAttribute('class', awsSpinner.getAttribute('class').replace('', ' d-none '))

    }
    function testAwsForSetup(e) {
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
        e.setAttribute('class', e.getAttribute('class').replace('', ' disabled '))
        e.textContent = "<?php echo lang('View.AdminPanel.website.awsTestButtonElementTextContextForWait'); ?>"
        let awsSpinner = document.getElementById('awsspinnerForSetup')
        awsSpinner.setAttribute('class', awsSpinner.getAttribute('class').replace(' d-none', ''))
        // Burada testSender kullanmamamızın sebebi transfer işlemlerini beklemek ve AWS sistemine özel senkron bir ajax
        // işlemi gerçekleştirmek
        requestDynamic('/setup/testawsforsetup', formData)
            .then(function (res) {
                    if (res.worked && !res.error) {
                        if (isSetEnv[res.name]) {
                            responseSuccessMessager(res.name, 'awscard', res.worked)
                            awsButtonWaitEnderWhenResponse(e,awsSpinner)
                        }
                    } else {
                        showMessage('awscard', '<p>' + cardIdTeller('awscard') + '<?php echo lang('View.setup.scripts.testSenderNotConfirm') ?>' + '</p>')
                        awsButtonWaitEnderWhenResponse(e,awsSpinner)
                     }
                }
            ).catch(function (e) {
            console.log('hata',e)
            awsButtonWaitEnderWhenResponse(e,awsSpinner)
        })
    }

    // -- FORM FIELDS PREPARE AND SEND END --


    // -- MESSAGER --

    function responseSuccessMessager(name, tab, res) {
        let message = messageCreator(name)
        if (isSetEnv[name]) {
            alert(cardIdTeller(tab) + ' ' + message)
            isSetEnv[name] = res
        } else {
            if (isSetEnv[name]) {
                alert('<?php echo lang('View.setup.scripts.shouldSettingsNoChange') ?>')
            }
        }
    }

    function showMessage(tabName, message) {
        // Her kartın card ile biten bir id etiket adı bulunmaktadır örneğin veritabanicard diye
        // bu gibi isimler tabName parametresine denk gelmektedir.
        // her kartta işleme göre div yaratılıp aktarılmaktadır.
        let tab = document.getElementById(tabName)
        let mainnode = document.createElement("div")
        let secondnode = document.createElement("div")
        let thirdnode = document.createElement("div")
        mainnode.setAttribute('class', 'row')
        secondnode.setAttribute('class', 'col-md-12 mt-4')
        thirdnode.setAttribute('class', 'col-md-offset-12 alert alert-warning')
        thirdnode.setAttribute('role', 'alert')
        // yaratılan elementlere gelen mesaj içeriğinde HTML elementleri bulunduğundan innerHTML kullanılmıştır
        thirdnode.innerHTML = message
        secondnode.appendChild(thirdnode)
        mainnode.appendChild(secondnode)
        tab.parentNode.insertBefore(mainnode, tab.nextSibling);
        // 7 saniye sonra gösterilen mesajın kaybolması için setTimeout ile sıfırlama uygulanır.
        setTimeout(function () {
            mainnode.innerHTML = ''
        }, 7000)
    }

    function resultCallbackReturner(res) {
        if (res.name) {
            if (res.name == 'db') {
                // unDisableFirst fonksiyonuna gönderilen 'veritabanı' parametresi id işlemlerini gerçekleştirmek içindir
                // o yüzden tanımlandığı gibi yazılması gerekir..
                unDisableFirst(document.getElementById('adminuser-tab'), 'veritabani')
            }

            if (res.worked && res.name == 'adminUser') {
                let saveForSetup = document.getElementById('saveForSetup');
                saveForSetup.setAttribute('class', saveForSetup.getAttribute('class').replace(' d-none', ''))
                // Kayıt işleminden sonra ikinci kayıdın önüne geçmek için butonu deaktif ediyoruz..
                let createAdminButton = document.getElementById('createAdminButton');
                createAdminButton.setAttribute('class', createAdminButton.getAttribute('class').replace('', ' disabled '))
                showMessage('adminusercard', "<?php echo lang('View.setup.scripts.readyForStart') ?>")
                unDisableBreakFree()
            }
        }
    }

    // -- MESSAGER END --

    // SETUP FINISHER

    function saveSetup(e) {
        let formData = new FormData();

        Object.keys(forms).forEach(key => {
            formData.append(key.toString(), forms[key].toString())
        });
        requestDynamic('/setup/savesetup', formData)
            .then(function (res) {
                window.location.replace('admin/site');
            }).catch(function (e) {
            console.log('hata')
        })
    }


    // AND ALL HELPERS..
    function unDisableBreakFree() {
        Object.keys(breakFree).forEach(key => {
            let breakedFree = document.getElementById(key + '-tab')
            breakedFree.setAttribute('class', breakedFree.getAttribute('class').replace(' disabled', ''))
        })
    }

    function unDisableFirst(e, otherElem) {
        // Burada bilinçli bir şekilde ve öğretici olması adına bu fonksiyon yazılmıştır..
        // console.log yardımı ile her seferinde nerelerde neler olduğunu incelemeniz faydalı olabilir..

        // Burada veri tabanı elementi id bilgileri
        e.setAttribute('class', e.getAttribute('class').replace(' disabled', ' active'))
        e.setAttribute('aria-selected', 'true')
        let pureId = e.id.replace('-tab', '')
        // console.log(pureId) << gözüne takıldıysa dene :)
        let forActivate = document.getElementById(pureId)
        forActivate.setAttribute('class', forActivate.getAttribute('class').replace('tab-pane fade', 'tab-pane fade show active'))

        // Burada yönetici elementi id bilgleri
        let pureOel = otherElem + '-tab'
        let oElTab = document.getElementById(pureOel)
        // console.log(pureOel) << gözüne takıldıysa dene :)
        oElTab.setAttribute('aria-selected', 'false')
        oElTab.setAttribute('class', oElTab.getAttribute('class').replace(' active', ' disabled'))
        let oEl = document.getElementById(otherElem)
        oEl.setAttribute('class', oEl.getAttribute('class').replace(' show active', ''))
    }

    function cardIdTeller(tabName) {
        if (tabName == 'veritabanicard') {
            return "<?php echo lang('View.setup.tabs.manuNames.database'); ?>"
        }
        if (tabName == 'adminusercard') {
            return "<?php echo lang('View.setup.tabs.manuNames.adminAccount'); ?>"
        }
        if (tabName == 'mailcard') {
            return "<?php echo lang('View.setup.tabs.manuNames.mailSettings'); ?>"
        }
        if (tabName == 'capctchacard') {
            return "<?php echo lang('View.setup.tabs.manuNames.captcha'); ?>"
        }
        if (tabName == 'awscard') {
            return "<?php echo lang('View.setup.tabs.manuNames.aws'); ?>"
        }

    }

    function messageCreator(name) {
        if (name == 'db') {
            return "<?php echo lang('View.setup.scripts.readyDb'); ?>"
        }
        if (name == 'mail') {
            return "<?php echo lang('View.setup.scripts.successTestMail'); ?>"
        }
        if (name == 'adminUser') {
            return "<?php echo lang('View.setup.scripts.successCreatedAdmin'); ?>"
        }
        if (name == 'aws') {
            return "<?php echo lang('View.setup.scripts.successAWS'); ?>"
        }
        if (name == 'captcha') {
            return "<?php echo lang('View.setup.scripts.successCaptcha'); ?>"
        }
    }


    function formCollector(element) {
        forms[element.name] = element.value

    }

    function togglingShow(e) {
        let logAttr = e.getAttribute('aria-expanded')
        e.textContent = logAttr == 'true' ? "<?php echo lang('View.setup.scripts.show'); ?>" : "<?php echo lang('View.setup.scripts.close'); ?>"
    }

</script>