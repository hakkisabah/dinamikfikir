

             ___ _                       _ _      ___ _ _    _          ___         __    
            /   (_)_ __   __ _ _ __ ___ (_) | __ / __(_) | _(_)_ __    / __\ /\/\  / _\   
           / /\ / | '_ \ / _` | '_ ` _ \| | |/ // _\ | | |/ / | '__|  / /   /    \ \ \    
          / /_//| | | | | (_| | | | | | | |   </ /   | |   <| | |    / /___/ /\/\ \_\ \   
         /___,' |_|_| |_|\__,_|_| |_| |_|_|_|\_\/    |_|_|\_\_|_|    \____/\/    \/\__/ 
                                                                                 
         _`~~generate from http://www.network-science.de/ascii/ and using ogre font~~`_
                                              
note: the introduction will be in Turkish and English, you can read the explanations in English in section 2.
# Teşekkürler

Mental olarak özgüvenimi pozitif olarak etkileyen  [Bülent BATMAZ](https://akademik.anadolu.edu.tr/bbatmaz) ve [Burak ÇAKIR](https://avesis.kocaeli.edu.tr/burak) hocalarıma teşekkürü bir borç bilirim.

##

[Jump Section 2](#section-2)

##
#Section 1
                      

#DinamikFikir CMS nedir / [Kurulum ve Kullanım Özet Video](https://youtu.be/0nQdQ6IcrrI)

DinamikFikir CMS çevik yaklaşımlarıyla basit bir içerik yönetim sistemidir, 
asıl amacı kullanılan yer sağlayıcının fiziksel alan kullanımını minimuma indirmek ve 
AWS S3 sistemi ile entegre çalışıp herkese açık olan dosyaları hızlı bir şekilde sunarak
ziyaretçilere kaliteli bir deneyim kazandırmaktır. 
Tüm bu fonksiyon ve özellikler PHP dilinde geliştirilen CodeIgniter 4.x çatısı altında inşa edilmiştir.

Sistem bir web kurulum sayfasına sahip olmakla birlikte sadece indir ve kur mantığıyla hareket etmektedir.
Bu özelliği hiç bir kod bilgisi gerektirmeden kurulum aşamasında ;
- Veritabanı hesap bilgileri ve Yönetici Hesabı oluşturma (Zorunlu)
- SMTP kullanıcı bilgileri (İsteğe bağlı)
- Google Captcha Anahtarları (İsteğe bağlı)
- AWS S3 Anahtarları (İsteğe bağlı)

girişlerini yaparak sade ve etkili editör ile birlikte içerik yönetim sistemini kullanmaya başlayabilirsiniz.

**_İçerik sistemi kayıt aktivasyon maili, şifre yenileme maili ve yönetici tarafından kullanıcıyı askıya alma, otomatik SEO ve bunun 
gibi bir çok kullanışlı özellik sunmaktadır.._**

**GitHub çoğunluğunun** gerekliliklerinden dolayı bundan sonraki kısım ingilizce devam edecektir.

Daha fazla geliştirme ve kurulum bilgileri için [DinamikFikir Başlangıç](https://dinamikfikir.com/content/baslangic) adresini ziyaret edebilirsiniz.

## Sunucu gereksinimleri


Aşağıdaki uzantıların kurulu olduğu PHP sürüm 7.2 veya üstü gereklidir:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](https://www.php.net/manual/en/mbstring.installation.php)

Ek olarak, PHP'nizde aşağıdaki uzantıların etkinleştirildiğinden emin olun:

- json (varsayılan olarak açık - kapatmayın)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (varsayılan olarak açın - kapatmayın)



##
#Section 2

#What is DinamikFikir CMS / [Installation and Usage Summary Video](https://youtu.be/0nQdQ6IcrrI)


DinamikFikir CMS is a simple content management system with agile approaches,
its main purpose is to minimize the use of physical space by the hosting provider used and
by integrating with the AWS S3 system and quickly serving public files
to provide visitors with a quality experience.
All these functions and features are built under the CodeIgniter 4.x PHP framework.

The system has a web setup page, it only operates with the download and setup logic.
This feature does not require any code knowledge during the installation phase;
- Database account information and creating an Administrator Account (Required)
- SMTP user information (Optional)
- Google Captcha Keys (Optional)
- AWS S3 Keys (Optional)

-- This link may be useful if you do not know about AWS keys => [Create AWS Access Key](https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_access-keys.html#Using_CreateAccessKey)

You can start using the content management system with the simple and effective editor.

**_Content system registration activation e-mail, password reset e-mail and user suspension by the administrator and auto SEO etc.
offers useful features .._**

## Installation
# NOTE : if you are using Cachewall or similar system then turn it off for this system

#### Download with git or download zip or [DinamikFikir CDN](https://cdn.dinamikfikir.com/public/uploads/dinamikfikirLatest.zip)

##### Required
-Run on your server and start installation (etc. enter localhost on your browser) and enter required.
![SetupIndex](https://cdn.dinamikfikir.com/public/uploads/Installation/1-2-DF-Setup-Database.jpg)

![SetupIndex](https://cdn.dinamikfikir.com/public/uploads/Installation/1-DF-Database-Setup-Success.jpg)

![SetupIndex](https://cdn.dinamikfikir.com/public/uploads/Installation/2-Admin-Account.jpg)
##### Optional
- Enter your SMTP mail information
![SetupIndex](https://cdn.dinamikfikir.com/public/uploads/Installation/3-Mail-Account.jpg)
- Enter your Google Captcha information
![SetupIndex](https://cdn.dinamikfikir.com/public/uploads/Installation/4-DF-Captcha.jpg)
- Enter your AWS information
![SetupIndex](https://cdn.dinamikfikir.com/public/uploads/Installation/5-AWS-Integration.jpg)


## To remind;

### About user and admin some permission
#### Admin features in general usage context:

- Admin can delete all content
- Admin can delete all comments

#### User features in the context of general use:

- The user can delete all comments for their own content.
- The user can delete in other content own comments.

### About the Mail System;

##### If an SMTP mail has been defined and the mail system is enabled, the mail and user system applies the following;

- An activation email is sent to the new user registration.
- If the user forgets his password, he can receive an activation email.
- The user has 2 days to complete mail activation. If he does not activate it within 2 days, the user when the first login in to the system, the user is informed that the account has been deleted and must be registered again.

#### Do not forget about the mail system;

- If you make the account SMTP account definition and the mail test result is successful, you should activate the system to use it. The system will not work unless you bring it.

- If one of the SMTP information is missing while your mail system is active, the system will not work. Knowing this is important for stability.

### About AWS S3;

- The main purpose of this system is to reduce the load on your hosting provider and provide a faster system.

- **There is a very important issue that; After installation, you need to choose Local or AWS from your Admin Panel. If you change the location after the content is started to be entered, the system will start to transfer all the images at the first content viewing to the selected location. This may cause your system to run unstable depending on resource availability.** 
- **As a recommendation,** obtaining S3 keys before system installation and introducing them to the DinamikFikir system before actively using the system will cause you to take much more stable steps for the future.

### Develop DinamikFikir

Open app\Controllers\YourController\Controller.php and 
remove comment tags on app\Config\Routes.php // Developing line , you will see this , so good starting for developing

## Server requirements


PHP version 7.2 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](https://www.php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (on by default - don't turn off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (open by default - don't turn off)

