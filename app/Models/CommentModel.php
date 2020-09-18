<?php


namespace App\Models;


use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $allowedFields =[
        'comment_id','updated_at','user_id','content_id',
        'comment','deleted_comment'];
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