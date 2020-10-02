<?php

return [
    'messages' => [
        'flashData' => [
            'userRequest' => [
                'afterRegisterForMailActivation' => 'Mailinizdeki aktivasyon linkini onayladıktan sonra giriş yapabilirsiniz. Mailinizdeki spam kutusunu kontrol etmeyi unutmayınız!',
                'succesWithoutActivation' => 'Başarıyla kayıt oldunuz mail adresinizle giriş yapabilirsiniz.',
                'userNeededActivation' => 'Lütfen aktivasyon işlemi için mailinizdeki aktivasyon linkini kullanınız.',
                'userNeedNewPassButActiovationNotWork' => 'Mail sistemi şu anda aktif değil lütfen yöneticiler ile irtibata geçiniz.',
                'userLaterForActivation' => 'Aktivasyon işlemi için geç kalmış görünüyorsunuz. Tekrardan Kayıt olmalısınız.',
                'newPass' => 'Mailinizdeki şifre yenileme linkine tıkladıktan sonra şifrenizi hesap ayarlarından yenileyiniz. Mailinizdeki spam kutusunu kontrol etmeyi unutmayınız!',
                'newPassFail' => 'Şifre yenileme İşleminiz şu anda işlenemiyor..',
                'newPassReminder' => 'Şifrenizi değiştirmeyi lütfen unutmayın !',
                'successRecord' => 'Kayıt Başarıyla Güncellendi',
                'locationChanges' => 'Lokasyon değişikliği yapılıyor yaklaşık 1 dakika içerisinde içerik işlemlerine devam edebilirsiniz.',
            ],
        ],
        'HTTP' => [
            'userRequest' => [
                'registerFail' => 'Kayıt İşleminiz şu anda işlenemiyor..',
                'activationEndPointFail' => 'Sistemde aktivasyon link uzantısı ayarlanmamış, yöneticilerle irtibata geçiniz',
                'newPassFail' => 'Şifre yenileme İşleminiz şu anda işlenemiyor..',
                'activationCodeRefused' => 'Aktivasyon kodunuz geçersiz.',
            ],
            'imageRequest' => [
                'tempImageErrorIsValid' => 'Lütfen geçerli bir dosya yükleyiniz',
            ],
            'userLogic'=>[
                'serverProblem'=>'Sunucu tabanlı bir problem yaşanıyor.',
            ],
            'errors'=>[
                'title' =>'Hoopss',
                'message'=>'birşeyler ters gitti.. {pageroute}'
            ]
        ],
        'SMTP' => [
            'userRequest' => [
                'activationMailSubject' => '{site_name} kullanıcı hesap aktivasyonu',
                'newPassSubject' => '{site_name} şifre yenileme',
            ],

        ],
    ],
];