<?php

namespace App\Filters;

use App\Controllers\ConstantBase;
use App\Controllers\Session;
use App\Controllers\SharedData\SharedData;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IndexDataUpdater implements FilterInterface
{
    /*
     * ITS NOT USE AT THIS VERSION
     */

    private $ConstantBase;
    private $SessionController;

    public function __construct()
    {
        $this->ConstantBase = new ConstantBase();
        $this->SessionController = new Session();
    }

    public function before(RequestInterface $request)
    {
        $DefaultExpire = $this->ConstantBase->ConstantInfo->indexDataMinuteValue;
        $SharedData = new SharedData();
            // ilk olarak gelen ziyaretçiye ait bir anasayfa yenileme zamanı değeri atanıp atanmadığına bakılır.
        $indexData = $this->SessionController->isSession('indexData');
            if (!empty($indexData)) {
                $this->SessionController->setSession('indexData', $SharedData->getIndexData()['result']);
                $this->SessionController->setTempSession('indexData', $DefaultExpire);
            }else{
                $isNewIndexData = $SharedData->getIndexData()['result'];
                if ($indexData !== $isNewIndexData){
                    $this->SessionController->setSession('indexData', $SharedData->getIndexData()['result']);
                    $this->SessionController->setTempSession('indexData', $DefaultExpire);
                }
            }
        unset($SharedData);

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {

    }

}