<?php

$adminValidation = require 'DF_Admin_Validation.php';
return [
    'errors' => [
        'admin_control'=>$adminValidation['errors']['admin_control'],
        'max_size' => 'Yüklediğiniz dosya boyutu {imageSize} geçemez.',
        'ext_in' => 'Sadece {imageExtensions}  uzantılı formatlar yüklenebilir.',
        'uploaded' => 'Lütfen okunabilen bir {whichOne} görseli yükleyiniz',
        'editorImage'=>'içerik',
        'titleImage'=>'başlık',
        'escUserInput'=>'Girmiş olduğunuz bilgiler arasında sakıncalı karakterler bulunmaktadır.',
        'escUserInputForTitle'=>'Başlık için doğru ifade girmediniz, kontrol edin.',

        'required_mail' => 'Mail adresinizi girmeniz gerekmekte.',
        'login_mail' => 'Lütfen geçerli ve kayıt olurken belirttiğiniz eposta adresinizi kullanınız',
        'required_title' => 'Başlık girmeniz gerekmekte.',
        'required_content' => 'Lütfen bir içerik giriniz.',
        'required_comment'=>'Boş bir yorum gönderilemez.',
        'required_login_pass'=>'Şifre girmeniz gerekmekte',
        'matches_pass'=>'Şifre onayınız geçemedi lütfen tekrar aynı şifreleri girerek deneyiniz.',
        'required_user_name'=>'Lütfen bir kullanıcı adı belirtiniz',
        'required_user_captcha'=>'Lütfen bir otomasyon yazılımı olmadığınızı bu formda bulunan "ben robot değilim" kutucuğuna tıklayarak onaylayınız',
        'required_first_name'=>'Lütfen bir isim belirtiniz.',
        'required_last_name'=>'Lütfen bir soyisim belirtiniz.',

        'min_length_first_name'=>'İsminiz {firstnameMin} karakterden az olamaz kontrol ediniz',
        'max_length_first_name'=>'İsminiz {firstnameMax} karakterden fazla olamaz kontrol ediniz',
        'min_length_last_name'=>'Soyisminiz {lastnameMin} karakterden az olamaz kontrol ediniz',
        'max_length_last_name'=>'Soyisminiz {lastnameMax} karakterden fazla olamaz kontrol ediniz',
        'min_length_pass' => 'Şifreniz {passMin} karakterden az olamaz lütfen kontrol ediniz',
        'max_length_pass' => 'Şifreniz {passMax} karakterden fazla olamaz lütfen kontrol ediniz',
        'min_length_user_name' => 'Kullanıcı adınız {userNameMin} karakterden az olamaz kontrol ediniz',
        'max_length_user_name' => 'Kullanıcı adınız {userNameMax} karakterden fazla olamaz kontrol ediniz',
        'min_length_user_mail' => 'Lütfen geçerli bir eposta adresi kullanınız. Minimum {emailMin} karakter içermeli',
        'max_length_user_mail' => 'Lütfen geçerli bir eposta adresi kullanınız. Maksimum {emailMax} karakter içermeli',
        'min_length_title' => 'Başlık en az {titleMin} karakterden oluşmalı',
        'max_length_title' => 'Başlık en fazla {titleMax} karakter olabilir',
        'min_length_content' => 'İçeriğiniz en az {contentMin} karakterden oluşmalı.',
        'max_length_content' => 'İçeriğiniz en fazla {contentMax} karakterden oluşmalı.',
        'min_length_comment' => 'Lütfen en az {commentMin} karakter içericek bir yorum yazınız.',
        'max_length_comment' => 'En fazla {commentMax} karakter içeren yorum yazabilirsiniz.',

        'is_unique_user_name' =>'Bu kullanıcı adı kullanımda lütfen daha farklı bir kullanıcı adı deneyiniz',
        'is_unique_user_mail' =>'Bu mail adresi daha önceden kullanılmış görünüyor, hesap size aitse şifreniz ile giriş yapabilirsiniz',
        'alpha_numeric_user_name'=>'Kullanıcı adınız sadece harf ve rakam içermeli, boşluk ve türkçe karakterler(ğ,ı,ö,ü,ç,ş gibi..) içermemeli',
        'checkSuspended' => 'Hesabınız dondurulmuştur, sistem yöneticileri ile irtibata geçiniz..',

        'validateContentSlug' => 'Bu başlık uygun değil, lütfen okunabilir ve daha önceden kullanılmamış bir başık giriniz.',
        'valid_user_email' =>'Lütfen geçerli bir eposta adresi kullanınız',
        'validateUser' => 'Email veya kullanıcı adı eşleşmiyor',
        'valideComment'=>'Güvenlik gereği herhangi bir html tagı kullanmayınız..',
    ],


];