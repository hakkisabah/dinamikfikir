<?php


namespace App\Controllers\View;


interface Pages
{
    public function home();

    public function dashboardIndex();

    public function contents();

    public function editor($slug = false);

    public function login();

    public function register();

    public function profile();

    public function publicprofile(string $userNameSlug);

    public function publiccontent(string $slug);

}