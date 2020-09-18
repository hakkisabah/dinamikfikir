<?php


namespace App\Controllers\Dashboard;

use App\Controllers\ConstantBase;

class Dashboard implements Dashboards
{

   public $ConstantBase;

    public function __construct()
    {
        $this->ConstantBase = new ConstantBase();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    /**
     * @return mixed
     */
    public function contents()
    {
        // TODO: Implement addcontent() method.
    }

    /**
     * @param array $result
     * @return mixed
     */
    public function editcontent(array $result)
    {
        if (isset($result) && count($result)>0) {
            $lastdata['result'] = $result;
            $lastdata['result']['currentBase'] = $this->ConstantBase->ConstantInfo->currentBase();
            if (!isset($lastdata['result']['user_id'])) {
                return false;
            } else {
                // Gelen istekte başlık resmini link olarak gösterecek.
                $lastdata['result']['title_image'] = $this->ConstantBase->ConstantInfo->publicTitleImageAddress($lastdata['result'])['title'];
                $lastdata['currentBase'] = $this->ConstantBase->ConstantInfo->currentBase();
                $lastdata['result'] = (object)$lastdata['result'];

                return $lastdata;
            }
        }else{
            return false;
        }
    }

}