<?php
namespace App\Controllers\User;

use App\Controllers\Organizer\ModelCaller;
use ReflectionException;

class User extends UserLogic implements Account
{
    /**
     * @var ModelCaller
     */
    public $ModelCaller;

    public $User;


    public function __construct()
    {
        $this->ModelCaller = new ModelCaller();
        parent::__construct();

    }


    public function getActivationUser($activationCode)
    {
        $isCodeHere = $this->ModelCaller->UserModel->where('activation_code',$activationCode)->find();
        return !empty($isCodeHere)?$isCodeHere[0]:[];
    }

    /**
     * @param object $request
     * @param string $activationCode
     * @return mixed
     * @throws ReflectionException
     */
    public function setAccount(object $request,$activationCode = '')
    {

        // esc() fonksiyonu ile güvenliği arttırarak test et
        $newData = [
            'firstname' => $request->getVar('firstname'),
            'lastname' => $request->getVar('lastname'),
            'user_name' => $request->getVar('user_name'),
            'user_email' => $request->getVar('user_email'),
            'user_password' => $request->getVar('user_password'),
        ];
        if (!empty($activationCode)){
            $newData['activation_code'] = $activationCode;
        }

        return $this->ModelCaller->UserModel->save($newData);
    }

    /**
     * @param $param
     * @param string $callOption
     * @return mixed
     *
     * expected functions name for getAccount on $functionName param
     * @function getUserInfoById
     * @function getUserInfoByName
     * @function getUserInfoByEmail
     */
    public function getAccount($param, string $callOption = '')
    {
        if ($callOption == 'getUserInfoById') {
            $callOption = 'user_id';
        } elseif ($callOption == 'getUserInfoByName') {
            $callOption = 'user_name';
        } else {
            $callOption = 'user_email';
        }
        $safe = $this->ModelCaller->UserModel
            ->where($callOption, $param)
            ->first();
        if ($safe){
            unset($safe['user_password']);
            return $safe;
        }else{
            return false;
        }
    }

    public function searchUser($param)
    {
        $safe = $this->ModelCaller->UserModel
            ->like('user_name', $param, 'both')
            ->limit(5)
            ->getWhere()
            ->getResultArray();
        if ($safe){
            foreach ($safe as $key => $value){
                unset($safe[$key]['user_password']);
            }
            return $safe;
        }else{
            return false;
        }
    }

    /**
     * @param array $newData
     * @return mixed
     */
    public function updateAccount(array $newData)
    {
        return $this->ModelCaller->UserModel
            ->where('user_name', $newData['user_name'])
            ->set($newData)
            ->update();
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function removeAccount(int $user_id)
    {
        return $this->ModelCaller->UserModel
            ->where('user_id', $user_id)->delete();
    }
}