<?php


namespace App\Controllers\User;


interface Account
{
    public function setAccount(object $request,$activationCode = '');

    public function getAccount($param, string $callOption);

    public function updateAccount(array $newData);

    public function removeAccount(int $user_id);
}