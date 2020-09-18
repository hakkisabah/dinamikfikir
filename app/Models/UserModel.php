<?php


namespace App\Models;


use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields =['firstname','lastname','user_id','user_name','user_email','email_status','activation_code','suspended','user_password','role','last_login_date','updated_at','icon_name'];
    protected $createdField='created_at';
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data){
        $data = $this->passwordHash($data);
        $data['data']['created_at'] = date('Y-m-d H:i:s');

        return $data;
    }

    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function passwordHash(array $data){
        if(isset($data['data']['user_password']))
            $data['data']['user_password'] = password_hash($data['data']['user_password'], PASSWORD_DEFAULT);

        return $data;
    }

}