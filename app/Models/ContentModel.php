<?php


namespace App\Models;


use CodeIgniter\Model;

class ContentModel extends Model
{
    protected $table = 'contents';
    protected $primaryKey = 'content_id';
    protected $allowedFields =[
        'user_id','updated_at','created_at',
        'content_id','title','old_title','title_image','content_images','is_local_image','slug','content','comment','comment_id'];
    protected $createdField= 'created_at';
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