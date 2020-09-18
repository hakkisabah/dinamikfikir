<?php


namespace App\Controllers;


class DashboardBase extends BaseController
{
    public $Content;
    public $ContentRequest;
    public $Dashboard;
    public $ConstantBase;



    public function __construct()
    {
        $this->Content = new Dashboard\Content();
        $this->ContentRequest = new Requests\ContentRequest();
        $this->Dashboard = new Dashboard\Dashboard();
    }

}