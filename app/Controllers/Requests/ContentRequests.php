<?php


namespace App\Controllers\Requests;


interface ContentRequests
{
    public function addcontent();

    public function updatecontent();

    public function deletecontent(string $slug);

}