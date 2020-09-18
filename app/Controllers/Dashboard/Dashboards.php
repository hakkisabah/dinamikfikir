<?php


namespace App\Controllers\Dashboard;


interface Dashboards
{
    public function index();

    public function contents();

    public function editcontent(array $result);
}