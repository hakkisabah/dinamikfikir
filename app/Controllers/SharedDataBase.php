<?php


namespace App\Controllers;


use App\Controllers\Requests\CommentRequest;
use App\Controllers\SharedData\Notifications;
use App\Controllers\SharedData\SharedData;

class SharedDataBase
{
    public $SharedData;
    public $Notifications;
    public $Comment;

    public function __construct()
    {
        $this->SharedData = new SharedData();
        $this->Comment = new CommentRequest();
        $this->Notifications = new Notifications();
    }

}