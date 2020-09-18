<?php

return [
    'index' => [
        'sideTitle' => 'Kurulum',
        'save' => 'Kaydet',
        'setupError' => 'Veri tabanı hatası, daha önceden ayarları yapılmış veri tabanına bağlanılamıyor',
    ],
    'tabs' => [
        'manuNames' => [
            'database' => 'Veritabanı',
            'adminAccount' => 'Yönetici Hesabı',
            'mailSettings' => 'Mail Ayarları',
            'captcha' => 'Google Captcha',
            'aws' => 'AWS Ayarları',
        ],
    ],
    'scripts' => [
        'shouldSettingsNoChange' => 'Ayarlarınızı fazla değiştirmemeniz önerilir..',
        'readyForStart' => 'HAZIRSINIZ ! Şu an zorunlu olan ayarlamaları yapmış bulunmaktasınız. İsterseniz kaydet butonuna tıklayarak kalan ayarları yönetici panelinizden yapabilirsiniz!',
        'readyDb' => ' başarıyla çalıştırıldı şimdi bir yönetici hesabı belirlemeniz gerekmekte..',
        'successTestMail' => ' başarıyla doğrulandı..',
        'successCreatedAdmin' => ' başarıyla oluşturuldu.',
        'successAWS' => ' bilgileri doğrulandı eşitleme başarılı !',
        'successCaptcha' => ' bilgileri alındı',
        'show' => 'Göster',
        'close' => 'Kapat',
        'testSenderNotConfirm' =>' doğrulanamıyor.. Lütfen kontrol ettikten sonra tekrar deneyiniz'
    ],
    'color_info' => [
        'titleColorFirst' => 'Başlık Renkleri',
        'titleColorLast' => ' hakkında bilgi almak için tıklayınız',
        'beMust' => 'Zorunlu',
        'beRequired' => 'Olması gerekli',
        'fastSystem' => 'Hızlı sistem',
        'lowModerate' => 'Düşük önemde',
    ],
    'databaseConf' => [
        'databaseCardLabel' => 'Veritabanı Ayarları',
        'databaseInfoLabel' => 'Veritabanı bilgileri',
        'databaseExplanation' => 'Veri tabanı bilgilerini girdikten sonra lütfen test ediniz.',
        'target' => 'Hedef',
        'targetPlaceHolder' => 'Örn : localhost',
        'userName' => 'Kullanıcı adı',
        'userNamePlaceHolder' => 'Örn : root',
        'pass' => 'Şifre',
        'passPlaceHolder' => 'Veritabanı şifresini giriniz',
        'databaseName' => 'Veritabanı ismi',
        'databaseNamePlaceHolder' => 'Örn : dinamikfikir',
        'test' => 'Test et',
    ],
    'adminUserConf' => [
        'adminCardLabel' => 'Yönetici Hesabı Ayarları',
        'adminInfoLabel' => 'Hesap bilgileri',
        'adminExplanation' => 'Kullanmak istediğiniz kullanıcı adı ve diğer bilgileri giriniz. Varsayılan olarak kullanıcı
            adınız admin olarak belirlenmiştir.',
        'userName' => 'Kullanıcı adı',
        'userNamePlaceHolder' => 'Örn : admin',
        'mailAddress' => 'Mail adresi',
        'mailAddressPlaceHolder' => 'Mail adresinizi giriniz',
        'userPass' => 'Şifre',
        'userPassPlaceHolder' => 'Hesap için şifre belirleyiniz',
        'userPassConfrim' => 'Şifre tekrarı',
        'userPassConfrimPlaceHolder' => 'Şifrenizi tekrar giriniz',
        'create' => 'Oluştur',

    ],
    'mailConf' => [
        'show' => 'Göster',
        'mailCardLabel' => 'Mail Ayarları',
        'mailInfoLabel' => 'Mail gönderme ayarları',
        'mailExplanation' => 'Sisteminizde şifre hatırlatma, aktivasyon maili vb.. işlemleri gerçekleştirebilmek için
            mail ayarlarınızı yapmanız gerekmektedir.. eğer bu ayarlar yapılmaz ise bu özellikleri kullanamayacaksınız..
            mail hesabınızı mutlaka test etmeniz gerekmektedir.. Ayrıca kurulumdan sonra detaylı mail ayarları admin panelinde
            sizi karşılıyor olacaktır..',
    ],
    'capctchaConf' => [
        'captchaCardLabel'=>'Google Captcha Ayarları',
        'captchaInfoLabel'=>'Google captcha anahatarları',
        'captchaExplanation'=>'Google tarafından gizli ve herkese açık olan site anahtarları girmeniz durumunda sistem
            yeni kayıt esnasında misafirin robot olup olmadığını kontrol edecektir..',
    ],
    'awsSystem'=>[
        'awsCardLabel'=>'AWS Sistemi',
        'show'=>'Göster',
        'awsInfoLabel'=>'AWS bilgileri',
        'awsExplanation'=>'AWS s3 sistemiyle bütünleşik çalışarak sistem yükünü büyük oranda azaltabilirsiniz !
         ayarlar için lütfen gerekli bilgileri giriniz..',
    ],
    'defaultMailEnv'=>[
        'MAIL_NAME'=>' Mail Servisi',
        'MAIL_DEFAULT_SUBJECT' =>' size bir posta yolladı',
        'MAIL_DEFAULT_MESSAGE_WELCOME' => 'Hoş geldiniz hesabınızı onaylamak için',
        'MAIL_DEFAULT_MESSAGE_LINK_TEXT' => ' buraya tıklayınız',
        'MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT' => 'Eğer bağlantıya tıklayamıyorsanız bu adresi : ',
        'MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT2' => ' kopyalayarak tarayıcınızla giriş yapabilirsiniz',
    ],
];