<?php


namespace App\Models;


use CodeIgniter\Model;

class IpTables extends Model
{
    protected $table = 'ip_tables';
    protected $primaryKey = 'ip_id';
    protected $allowedFields =['ip_id','ip_address','user_name','user_device_info','end_point','updated_at','cookie_consent'];
    protected $createdField='created_at';
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data){
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function beforeUpdate(array $data){
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }
}