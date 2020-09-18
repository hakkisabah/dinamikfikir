<?php


namespace App\Models;

use CodeIgniter\Model;

class NotificationsModel extends Model
{

    protected $table = 'user_notifications';
    protected $primaryKey = 'notification_id';
    protected $allowedFields =[
        'owner_user_name','user_name','updated_at','created_at',
        'notification_id','unread','notification_where','notification_where_id','notification_field','notification_field_id'];
    protected $createdField= 'created_at';
    protected $updatedField= 'updated_at';
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