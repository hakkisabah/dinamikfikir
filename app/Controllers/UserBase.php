<?php


namespace App\Controllers;


use App\Controllers\Extension\Icons;
use App\Controllers\Requests\UserRequest;

class UserBase
{
    public $UserRequest;
    public $Icons;
    public function __construct()
    {
        $this->UserRequest = new UserRequest();
        $this->Icons = new Icons();
    }
}