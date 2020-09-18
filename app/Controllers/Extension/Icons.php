<?php


namespace App\Controllers\Extension;


use App\Controllers\BaseController;
use App\Controllers\Constant\ConstantInfo;
use App\Controllers\Organizer\ModelCaller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Icons extends BaseController
{
    public $Icons;
    public $IconBaseAddress;
    public $ModelCaller;

    public function __construct()
    {
        $this->ModelCaller = new ModelCaller();
        $this->Icons = 'blank.svg,boy.svg,boy-1.svg,boy-2.svg,girl.svg,girl-1.svg,girl-2.svg,girl-3.svg,girl-4.svg,girl-5.svg,girl-6.svg,girl-7.svg,girl-8.svg,man.svg,man-1.svg,man-2.svg,man-3.svg,man-4.svg,man-5.svg';
        $this->IconBaseAddress = (new ConstantInfo())->getIconState();
    }

    public function iconGetter($iconName)
    {
        $tempIconNumber = array_search($iconName, explode(',', $this->Icons));
        return explode(',', $this->Icons)[$tempIconNumber];
    }

    public function getUserIcon($userName)
    {
        return $this->ModelCaller->UserModel->
        select('icon_name')->
        where('user_name', $userName)
            ->find();
    }

    public function saveAvatar()
    {
        if ($this->request->getMethod() == 'post') {
            $gettingAvatarName = $this->request->getVar('savedAvatar');
            if($this->iconGetter($gettingAvatarName)){
                $this->ModelCaller->UserModel
                    ->where('user_id',session()->get('userInfo')['user_id'])
                    ->set(['icon_name' => $gettingAvatarName])
                    ->update();
                $userInfo = session()->get('userInfo');
                $userInfo['icon_name'] = $gettingAvatarName;
                session()->set('userInfo',$userInfo);
                return $this->response->setStatusCode(200)->setJSON([
                    "icon"=>
                        $this->IconBaseAddress . $gettingAvatarName
                ]);
            }else{
                throw PageNotFoundException::forPageNotFound();
            }
        }else{
            throw PageNotFoundException::forPageNotFound();
        }
    }
}