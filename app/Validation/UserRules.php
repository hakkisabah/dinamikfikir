<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{

    public function validateUser(string $str, string $fields, array $data){
        $model = new UserModel();
        $user = $model->where('user_email', $data['user_email'])
            ->first();

        if(!$user) {
            return false;
        }else{
            $a = new \DateTime('now');
            $model->where('user_email', $data['user_email'])
                ->set(['last_login_date' => $a->format('Y-m-d h:i:s')])
                ->update();
            return password_verify($data['user_password'], $user['user_password']);
        }

    }

    public function checkSuspended(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('user_email', $data['user_email'])
            ->first();
        if ($user['suspended'] != 0){
            return false;
        }else{
            return true;
        }
    }

    public function is_mail_have(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('user_email', $data['user_email'])
            ->first();
        if (!$user){
            return false;
        }else{
            return true;
        }
    }

    public function user_update_validator_for_email(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('user_email', $data['user_email'])
            ->first();
        if (!$user){
            return true;
        }
        if (!empty($user['user_email']) && $user['user_email'] != $data['user_email']){
            return false;
        }elseif(!empty($user['user_email']) && $user['user_email'] == $data['user_email']){
            return true;
        }
    }

}