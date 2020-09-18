<?php


namespace App\Controllers\SharedData;


use App\Controllers\BaseController;
use App\Controllers\Organizer\ModelCaller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Notifications extends BaseController
{

    public $ModelCaller;

    public function __construct()
    {
        $this->ModelCaller = new ModelCaller();
    }

    public function getNotifications($ownerUserName)
    {
        $tempNotifications = $this->ModelCaller->NotificationModel
            ->where('owner_user_name', $ownerUserName)
            ->where('unread', 1);
        $tempgettingNotifications = $tempNotifications->getWhere();
        $tempNotifications = $tempgettingNotifications->getResult();
        return $tempNotifications;
    }

    public function setNotification($ownerUserName,
                                    $userName,
                                    $notificationWhere,
                                    $notificationWhereId,
                                    $notificationField,
                                    $notificationFieldId
    )
    {
        $newData = [
            'notification_where' => $notificationWhere,
            'notification_where_id' => $notificationWhereId,
            'notification_field' => $notificationField,
            'notification_field_id' => $notificationFieldId,
            'user_name' => $userName,
            'owner_user_name' => $ownerUserName
        ];
        try {
            $this->ModelCaller->NotificationModel->save($newData);
        } catch (\ReflectionException $e) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function readNotification()
    {
        if ($this->request->getMethod() == 'post') {
            $notificationWhereId = $this->request->getVar('notificationvar');
            $this->ModelCaller->NotificationModel
                ->where('notification_where_id', $notificationWhereId)
                ->where('owner_user_name',
                    session()->get('userInfo')['user_name'])
                ->set(['unread' => 0])
                ->update();
        }else{
            throw PageNotFoundException::forPageNotFound();
        }

    }
}