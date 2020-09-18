<?php


namespace App\Controllers;


interface Sessions
{

    public function setSession(string $key, $payload);

    public function getSession(string $keyName);

    public function removeSession(string $key = null);

    public function isSession(string $key);

}