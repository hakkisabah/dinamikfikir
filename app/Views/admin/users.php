<?php
if (!empty($admin_users_data)) {
    $data['admin_users_data'] = $admin_users_data;
    ?>
    <link href="<?= $data['admin_users_data']['cssTarget'] ?>" rel="stylesheet" type="text/css"/>
    <div class="row">
        <?php if (session()->get('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('success') ?>
            </div>
        <?php endif; ?>

        <div class="col-lg-6 mt-3 pt-3 pb-3 form-wrapper">
            <div class="container">
                <?php
                echo view('admin/user/user_search', $data);
                ?>
            </div>
        </div>
        <div class="col-lg-6 mt-3 pt-3 pb-3 form-wrapper">
            <div class="container">
                <?php
                echo view('admin/user/user_detail');
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
    left: 10px; " onclick="updateUserConf()" role="button"><?php echo lang('View.AdminPanel.users.update'); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    echo lang('View.AdminPanel.users.pageError');
} ?>

<script>
    // Kullanıcı bilgileri her değiştiğinde forms değişkenine aktarılır.
    let forms = {}
    // Sunucudan gelen kullanıcı arama sonuçları searched değişkenine aktarılır.
    let searched = []
    // myList elementi içinde dinamik olarak arama sonucu elde edilen kullanıcı isimleri listelenir
    // bu userGetter(res) fonksiyonu ile sağlanır..
    let myList = document.getElementById("myList")
    // Kullanıcı detaylarının html elementlerini barındıran formun id adı,
    // bu bilgi sayesinde detaylarını görmek istediğimiz kullanıcının bilgilerini, bu formun içinde
    // bulunan ve sunucudan gelen veri anahtarları ile aynı name etiketine sahip olan html elementlerine aktarılır.
    let userDetailForm = document.getElementById('userConf')
    // Kullanıcıya tekrardan aktivasyon göndermek için kullanılan buton, bu buton değer olmadığı zamanlarda disabled modu alır.
    let activationButton = document.getElementById('reActivationButton')
    // Kullanıcı askıya alma butonu aktivasyon butonu ile aynı element özelliklerine sahip fakat işlevleri farklıdır.
    let suspendedForButton = document.getElementById('suspendedForButton')
    // Kullanıcı aranan html elementi aranan kullanıcı isimlerini aktarmak için köprü görevi görür.
    let searchUser = document.getElementById('searchuser')

    // Kullanıcı Güncelleme
    function updateUserConf() {
        // Form oluşturuyoruz..
        let formData = new FormData();
        // formCollector() fonksiyonunun sayesinde forms değişkeninde toplanan verileri okmaya başlıyoruz
        Object.keys(forms).forEach(key => {
            // okunan veriler işlenmek üzere bir araya toplanıyor..
            formData.append(key.toString(), forms[key].toString())
        });
        // hangi kullanıcıyı güncelleyeceğimizi son olarak göndereceğimiz değişkene aktarıyoruz.
        let currentUserName = document.getElementById('user_name')
        formData.append('user_name', currentUserName.value)
        // Herşey tamamlandıktan sonra güncelleme adresine isteğimizi yolluyoruz..
        requestDynamic('/admin/updateuser', formData)
            .then(function (res) {
                // Gelen cevabı mantıksal sınamaya alıyoruz..
                if (res.updatedUser) {
                    alert(res.updatedUser === true ? '<?php echo lang('View.AdminPanel.users.userUpdateSuccess'); ?>' : res.updatedUser)
                    location.reload();
                } else {
                    showMessageForAdminUserPanel('userError', res.validation)
                    window.location.hash = '#userSearch';
                    history.pushState("", document.title, window.location.pathname); // https://stackoverflow.com/questions/4508574/remove-hash-from-url/37853332
                }
            }).catch(function (e) {
            alert('<?php echo lang('View.AdminPanel.users.serverError'); ?>')
            console.log(e)
        })
    }

    // Kullanıcı arama kutusunda entera basıldığında sayfa yenilemesinden kaçınmak için
    // arama kutusuna bir dinleyici yerleştiriyoruz..
    searchUser.addEventListener('keydown', function (e) {
        if (e.key == 'Enter') {
            e.preventDefault();
            return false;
        }
    })

    function showMessageForAdminUserPanel(tabName, message) {
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

    // getUser(e) Seçilen kullanıcıyı verilen dizi paremetresine göre getirir
    function getUser(e) {
        // Kullanıcı seçildiğinde arama sonucunu silmemiz gerekli
        myList.innerHTML = ''
        activationButton.disabled = false
        suspendedForButton.disabled = false
        Object.keys(searched[e.value]).forEach(key => {
            let liNode = document.getElementsByName(key)
            if (liNode.length != 0) {
                if (key == 'suspended') {
                    let isTrue = searched[e.value][key] == 1 ? ' active' : ''
                    suspendedForButton.setAttribute('class', 'btn btn-toggle' + isTrue)
                }
                userDetailForm.elements.namedItem(key).setAttribute('value', searched[e.value][key])
            }
        })
        searchUser.value = e.textContent
        // Önemli..
        // Kullanıcı detayı görüntüleme bu fonksiyon aracılığı ile yapılmaktadır.
        // Kullanıcı detayları işlemi sonunda mutlaka searched değişkenini sıfırlamamız gerekli..
        searched = {}

    }

    // gönderilen sorgu sonucu gelen cevabı arama kutusunun
    // altında okunacak şekilde kullanıcı isimlerini sıralar..
    function userGetter(res) {
        // Sıralamadan önce he zaman bir önceki sıralanmış verileri siler..
        myList.innerHTML = ''
        if (res.user !== false) {
            searched = res.user
            Object.keys(searched).forEach(key => {
                let node = document.createElement("LI")
                let textnode = document.createTextNode(searched[key].user_name)
                node.setAttribute('class', 'list-group-item')
                node.setAttribute('onclick', 'getUser(this)')
                node.setAttribute('value', key)
                node.appendChild(textnode)
                myList.appendChild(node);
            })
        }
    }

    // Kullanıcı adı arama kutusuna yazılan her karakteri arama yapmak için sunucuya gönderir.
    function userSearcher(e) {
        if (e.value) {
            let formData = new FormData();
            formData.append('searchuser', e.value)
            if (e.value != '') {
                requestDynamic('/admin/searchuser', formData)
                    .then(function (res) {
                        userGetter(res)
                    }).catch(function (e) {
                    console.log(e)
                })
            }
        } else {
            // Eğer arama kutusunda hiç bir karakter yoksa herşeyi eski haline getiriyoruz.
            userDetailForm.reset()
            suspendedForButton.setAttribute('class', 'btn btn-toggle')
            activationButton.disabled = true
            suspendedForButton.disabled = true
            myList.innerHTML = ''
        }

    }

    function formCollector(element) {
        forms[element.name] = element.value
    }

    // Kullanıcıya gönderilecek yeni aktivasyon kodu fonksiyonu.
    function reActivation() {
        let formData = new FormData();
        // Bu kod bloğunda formData değişkenine aktardığımız kısma biraz dikkat etmemiz gerekli
        // html etiketleri içerisinde sadece bir tane user_name isminde id ve name işaretlemesi bulunuyor..
        formData.append('reActivationUser', document.getElementById('user_name').value)
        requestDynamic('/admin/reactivation', formData)
            .then(function (res) {
                if (res.reActivation) {
                    alert('<?php echo lang('View.AdminPanel.users.reActivation'); ?>')
                } else {
                    alert('<?php echo lang('View.AdminPanel.users.reActivationElse'); ?>')
                }
            }).catch(function (e) {
            console.log(e)
            alert('<?php echo lang('View.AdminPanel.users.reActivationErrorFromServer'); ?>')
        })
    }

    // Kullanıcı askıya alma fonksiyonu
    function suspendswitcher(idName) {
        let log = document.getElementById(idName)
        log.value = log.value == 0 ? 1 : 0
        forms[log.name] = log.value
    }
</script>
