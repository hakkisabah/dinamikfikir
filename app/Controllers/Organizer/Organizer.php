<?php

namespace App\Controllers\Organizer;

use App\Controllers\ConstantBase;
use App\Controllers\Session;
use App\Controllers\SharedData\Notifications;

class Organizer
{
    /**
     * @var Limits
     */
    private $queryLimitsOrganizer;
    /**
     * @var ModelCaller
     */
    private $ModelCaller;

    private $SessionController;

    public function __construct()
    {
        $this->queryLimitsOrganizer = (new ConstantBase())->Limits;
        $this->ModelCaller = new ModelCaller();
        $this->SessionController = new Session();
    }

    private function contentlooper($session)
    {
        // sorgudan gelecek dataların limiti..
        $limit = $this->queryLimitsOrganizer->queryLimit;
        $data = [];
        $lastdata = [];
        $isLogged = $this->SessionController ->getSession('userInfo')[$session];
        // Eğer kullanıcı login olamamışsa değer false döner.
        if (empty($isLogged)) return false;
        // Kullanıcıya ait içerikler
        $lastdata['result'] = $this->ModelCaller->ContentModel->where($session, $this->SessionController ->getSession('userInfo')[$session])
            ->orderBy('content_id', 'DESC')
            ->limit($limit);

        $gettingdata = $lastdata['result']->getWhere();
        $lastdata['result'] = $gettingdata->getResult();
        // kullanıcıya ait içerikler array_reverse ile sondan başlanarak işleniyor
        foreach ($lastdata['result'] as $key => $contents) {

            $data['contentForDashboard'][$contents->content_id] = $contents;

        }
        return $data;

    }

    private function commentlooper($data)
    {
//        $data = [];
        $lastdata = [];
        // içerğie ait yorumlar tespit ediliyor..
        if (isset($data['contentForDashboard'])) {
            foreach ($data['contentForDashboard'] as $key => $value) {
                $lastdata['commentResults'] = $this->ModelCaller->CommentModel->where('content_id', $value->content_id)
                    ->orderBy('comment_id','DESC');
                $tempgetting = $lastdata['commentResults']->getWhere();
                $lastdata['commentQueryResults'][$value->content_id] = $tempgetting->getResult();
            }
            foreach ($lastdata['commentQueryResults'] as $key => $value) {
                if (count($lastdata['commentQueryResults'][$key]) > 0) {
                    $lastdata['userResultForComment'][$lastdata['commentQueryResults'][$key][0]->content_id] = $value;
                }
            }
        }
        return $lastdata;
    }

    private function userlooper($lastdata)
    {
        $Notifications = new Notifications();
        $usernameForNotification = $this->ModelCaller->UserModel
            ->where('user_name',$this->SessionController ->getSession('userInfo')['user_name'])
            ->find()[0]['user_name'];
        $readyNotification = $Notifications->getNotifications($usernameForNotification);

        $lastdata['userResultForCommentMerged'] = $readyNotification;


        return $lastdata;
    }

    public function internalCall()
    {
        $data = $this->contentlooper('user_id');
        // $Organizer->contentlooper dan dönen değere göre işlem yapılır.
        if ($data === false) return redirect()->to('/users/login');
        $lastdata = $this->commentlooper($data);
        $lastdata = $this->userlooper($lastdata);
        if (isset($lastdata['userResultForCommentMerged'])) {
            $data['userResultForCommentMerged'] = $lastdata['userResultForCommentMerged'];
            // Hafızada yer kaplamaması için lastdatayı boşaltıyoruz.
            $lastdata = [];
        }
        return $data;
    }


}