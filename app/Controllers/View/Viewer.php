<?php


namespace App\Controllers\View;


class Viewer extends ViewData
{

    public function headerIndex($data = [])
    {
        $data['headerIndex'] = $this->header_data(!empty($data['header']) ? $data['header'] : $data['header'] = []);
        $data['navIndex'] = $this->nav_data(!empty($data['nav']) ? $data['nav'] : $data['nav'] = []);
        echo view('header/index', $data);
        echo view('nav/index', $data);
    }

    public function footerIndex()
    {
        $data['footerIndex'] = $this->footer_data($data = []);
        echo view('footer/index', $data);
    }
    public function homeIndex($data = [])
    {

        if (empty($data)) {
            $data['card_data'] = $this->card_data();
            $this->headerIndex($data['card_data']['seo']);
            // card_data dizisine eğer veritabanından çekilen bilgiler gönderilecekse bu contentData şeklinde tanımlanmalı
            echo view('shared/card_loop', $data);
            $this->footerIndex();
        } else {
            throw PageNotFoundException::forPageNotFound();
        }

    }

    public function KVKK()
    {
        $this->headerIndex($data = []);
        echo view('KVKK/index');
        $this->footerIndex();
    }

    public function adminReport()
    {
        $this->headerIndex($data = []);
//        $data['admin_report_data'] = $this->admin_report_data();
        echo view('admin/report', $data);
        $this->footerIndex();
    }

    public function adminSite()
    {
        $this->headerIndex($data = []);
        $data['admin_site_data'] = $this->admin_site_data();
        echo view('admin/website', $data);
        $this->footerIndex();
    }

    public function adminUsers()
    {
        $this->headerIndex($data = []);
        $data['admin_users_data'] = $this->admin_users_data();
        echo view('admin/users', $data);
        $this->footerIndex();
    }
    public function adminContents()
    {
        $this->headerIndex($data = []);
        $data['admin_contents_data'] = $this->admin_contents_data();
        echo view('admin/contents', $data);
        $this->footerIndex();
    }

    public function dashIndex()
    {
        $this->headerIndex($data = []);
        $data['logoSubline'] = $this->logoSubline();
        echo view('shared/logo_info_line', $data);
        // card_data dizisine eğer veritabanından çekilen bilgiler gönderilecekse bu contentData şeklinde tanımlanmalı
        $data['card_data'] = $this->card_data();
        echo view('shared/card_loop', $data);
        $this->footerIndex();
    }

    public function login($data = [])
    {
        $this->headerIndex();
        $data['loginIndex'] = $this->login_data();
        echo view('login/index', !empty($data) ? $data : $data = []);
        $this->footerIndex();
    }

    public function forgot($data = [])
    {
        $this->headerIndex();
//        $data['forgotIndex'] = $this->forgot_data();
        echo view('login/forgot', !empty($data) ? $data : $data = []);
        $this->footerIndex();
    }

    public function register($data = [])
    {
        $this->headerIndex();
        $data['registerIndex'] = $this->register_data();
        echo view('register/index', $data);
        $this->footerIndex();
    }

    public function profile($data = [])
    {
        $this->headerIndex();
        echo view('profile/index', !empty($data) ? $data : '');
//        $data['profileIndex'] = $this->profile_data($data);
        $data['profileAvatars'] = $this->profile_avatar_data($data);
        echo view('profile/avatar', $data);
        $this->footerIndex();
    }


    public function dashContents()
    {
        $this->headerIndex();
        $data['logoSubline'] = $this->logoSubline();
        echo view('shared/logo_info_line', $data);
        $data['dashboard_contents_data'] = $this->dasboard_contents_data();
        echo view('dashboard/contents', $data);
        $this->footerIndex();
    }

    public function dashEditor($data = [])
    {
        $this->headerIndex();
        $data['logoSubline'] = $this->logoSubline();
        echo view('shared/logo_info_line', $data);
        $data['currentEditorCssLink'] = $this->ConstantBase->ConstantInfo->currentBase() . 'public/assets/editor/dist/css/quill.snow.1.3.6.css';

        echo view('dashboard/editor', !empty($data) ? $data : '');
        $this->footerIndex();

    }

    public function publicContent($data = [])
    {
        // Eğer Herkese açık içeriğe gönderilen yorumda bir problem var ise bu yorum hatası olarak
        // tekrar bu noktadan hareket edecektir ve datanın içinde ['public_content_data'] birlikte
        // ['validation'] hata dizisi olacağından veriler işlenirken herhangi bir karışıklığın önüne geçmek
        // adına public_content_data fonksiyonuna sadece ['public_content_data'] dizisi gönderilir.
        // bu Page.php sayfasında publiccontent tarafından çağırılan işlemle eşdeğerdir.
        if (!empty($data['public_content_data'])) {
            $data['public_content_data'] = $this->public_content_data($data['public_content_data']);
            $this->headerIndex(!empty($data['public_content_data']) ? $data['public_content_data']['seo'] : '');
            echo view('publiccontent/index', $data);
        } else {
            // Eğer hata yok ise normal bir şekilde devam edecektir..
            // $datadan gelmiş olan/olacak ve public_content ile oluşacak veri fazlalığını geçici değişken vasıtası ile
            // işleme koyuyoruz.
            $temp = $data;
            $data = [];
            $data['public_content_data'] = $this->public_content_data($temp);
            $this->headerIndex(!empty($data['public_content_data']) ? $data['public_content_data']['seo'] : '');
            echo view('shared/json_ld_for_seo', $data['public_content_data']['seo']);
            unset($data['seo']);
            echo view('publiccontent/index', $data);
        }
        $this->footerIndex();

    }

    public function publicUser($data = [])
    {
        $this->headerIndex(!empty($data['header']) ? $data['header'] : $data['header'] = []);
        // card_data dizisine eğer veritabanından çekilen bilgiler gönderilecekse bu contentData şeklinde tanımlanmalı
        $data['card_data'] = $this->card_data(!empty($data) ? $data : $data = []);
        // Sıra buraya geldiğinde entegre edip kontrol et.
        echo view('shared/card_loop', $data);
        $this->footerIndex();

    }
}