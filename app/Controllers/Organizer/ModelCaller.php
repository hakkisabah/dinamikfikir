<?php


namespace App\Controllers\Organizer;


use App\Models\CommentModel;
use App\Models\ContentModel;
use App\Models\NotificationsModel;
use App\Models\UserModel;

class ModelCaller
{

    public $ContentModel;
    public $UserModel;
    public $CommentModel;
    public $NotificationModel;

    public function __construct()
    {
        $this->ContentModel = new ContentModel();
        $this->UserModel = new UserModel();
        $this->CommentModel = new CommentModel();
        $this->NotificationModel = new NotificationsModel();
    }

    public function finContentAsObject($field, $data)
    {
        return $this->ContentModel->asObject()->where($field, $data)->find();
    }

    public function finUsertAsObject($field, $userId)
    {
        return $this->UserModel->asObject()->where($field, $userId)->find();
    }

}