<?php
namespace App\Controllers\YourController;

use App\Controllers\BaseController;

class Controller extends BaseController
{

    // NOTE :
    // IF you test and use this class before open Config\Routes.hp and uncomment // Developing line

    public $DashboardBase;
    public $UserBase;
    public function __construct()
    {
        $this->DashboardBase = new \App\Controllers\DashboardBase();
        $this->UserBase = new \App\Controllers\UserBase();
    }

    public function getUser($username)
    {
        // For example your username admin
        // then test on your browser /yourcontroller/getuser/admin
        print_r($this->UserBase->UserRequest->getAccount($username,'getUserInfoByName'));
    }
    public function getContent($slug)
    {
        // For example your content slug aaa
        // then test on your browser /yourcontroller/getcontent/aaa
        print_r($this->DashboardBase->Content->getContent('slug',$slug));
    }

}