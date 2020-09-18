<?php


namespace App\Controllers;


class ConstantBase
{
    public $Limits;

    public $ConstantInfo;

    public function __construct()
    {
        $this->Limits = new Constant\Limits();
        $this->ConstantInfo = new Constant\ConstantInfo();
    }

}