<?php


namespace App\Controllers\Constant;


class Limits
{
    public $queryLimit;
    public $passMin;
    public $passMax;
    public $firstnameMin;
    public $firstnameMax;
    public $titleMin;
    public $titleMax;
    public $contentMin;
    public $contentMax;
    public $commentMin;
    public $commentMax;
    public $emailMin;
    public $emailMax;
    public $reportLimit;

    public function __construct()
    {
        $this->reportLimit = 50;
        $this->queryLimit = '10,0';
        $this->emailMin = 6;
        $this->emailMax = 50;
        $this->passMin = 8;
        $this->passMax = 255;
        $this->firstnameMin = 3;
        $this->firstnameMax = 20;
        $this->titleMin = 3;
        $this->titleMax = 50;
        $this->contentMin = 20;
        $this->contentMax = 20000;
        $this->commentMin = 10;
        $this->commentMax = 10000;
    }


}