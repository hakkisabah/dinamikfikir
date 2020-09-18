<?php namespace App\Filters;

use App\Controllers\Dashboard\Content;
use App\Controllers\SharedData\Notifications;
use App\Controllers\Requests\UserRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class NotificationSetter implements FilterInterface
{

    public function before(RequestInterface $request)
    {

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {

        // Dikkat ! veritabanı alanları genel kullanım için ayarlanmıştır..
        // fakat şu an sadece içerik yorumları için çalışır..
        // genel hale dönüştürmek için bir kaç modifikasyon gereklidir..

        // İşlem tamamlandıktan sonra bildirim kaydı oluşturulur.
        $ContentClass = new Content();
        $UserClass = new UserRequest();
        $Notification = new Notifications();
        $contentId = $request->getVar('content_id');
        $forUserId = $ContentClass->getContent('content_id',$contentId);

        // Eğer yorum yapan kişi yorum yapılan içeriğin sahibi değilse bildirim kayıt edilecek.
        if (isset($forUserId) && $forUserId['user_id'] != session()->get('userInfo')['user_id'] && session()->get('tempNotificationId')) {
            $Notification->setNotification(
            // İçerik sahibinin kullanıcı kimliği
                $UserClass->getAccount($forUserId['user_id'],'getUserInfoById')['user_name'],
                // Yorum sahibinin kullanıcı kimliği
                $UserClass->getAccount(session()->get('userInfo')['user_id'],'getUserInfoById')['user_name'],
                'content_id',
                $contentId,
                'comments',
                session()->get('tempNotificationId')
            );
        }
        session()->remove('tempNotificationId');
        unset($ContentClass);
        unset($UserClass);
        unset($Notification);
    }
}