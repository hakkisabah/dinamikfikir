<?php


namespace App\Controllers\SharedData;


use App\Controllers\Constant\Limits;
use App\Controllers\ConstantBase;
use App\Controllers\Organizer\ModelCaller;
use App\Controllers\Requests\UserRequest;
use App\Controllers\User\User;
use App\Controllers\Validate\Validator;

class SharedData implements SharedDatas
{
    /**
     * @var ModelCaller
     */
    public $ModelCaller;
    /**
     * @var Limits
     */
    public $queryLimitsOrganizer;
    /**
     * @var Validator
     */
    public $subValidator;

    public function __construct()
    {
        $this->queryLimitsOrganizer = (new ConstantBase())->Limits;
        $this->subValidator = new Validator();
        $this->ModelCaller = new ModelCaller();

    }

    public function getIndexData()
    {
        // sorgudan gelecek dataların limiti..
        $limit = $this->queryLimitsOrganizer->queryLimit;
        $lastdata = [];
        // Kullanıcıya ait içerikler
        $lastdata['result'] = $this->ModelCaller->ContentModel->select()
            ->orderBy('content_id', 'DESC')
            ->limit($limit);

        $gettingdata = isset($lastdata['result']) ? $lastdata['result']->getWhere() : '';
        $lastdata['result'] = isset($gettingdata) ? $gettingdata->getResult() : '';
        return $lastdata;
    }

    public function getPublicContent($where, $slug)
    {
        $limit = $this->queryLimitsOrganizer->queryLimit;
        $lastdata['publicResult'] = $this->ModelCaller->ContentModel->where($where, $slug)->find();
        $lastdata['mergedCommentForBoth'] = $this->ModelCaller->CommentModel->where('content_id', $lastdata['publicResult'][0]['content_id'])
            ->orderBy('comment_id', 'DESC')
            ->limit($limit);

        $gettingdata = $lastdata['mergedCommentForBoth']->getWhere();
        $lastdata['mergedCommentForBoth'] = $gettingdata->getResult();

        if (!$lastdata['publicResult']) return redirect()->to('/');
        $accountRequest = new UserRequest();
        $user =  $accountRequest->getAccount($lastdata['publicResult'][0]['user_id'],'getUserInfoById');
        if (!empty($user['user_name'])) {
            $lastdata['publicResult']['ContentsUserInfo'] = $user;
        }
        unset($user);
        if (!empty($lastdata['mergedCommentForBoth'])){
            foreach ($lastdata['mergedCommentForBoth'] as $key => $value){
                $lastdata['commentedUserInfo'][$key] = $accountRequest->getAccount($value->user_id,'getUserInfoById');
            }
        }
        if ($lastdata['publicResult']){
            return $lastdata;
        }else {
            return false;
//            echo view('errors/html/production.php');
        }

    }

    public function getPublicUserInfo($userNameSlug)
    {
        $data = [];
        $user = (new UserRequest())->getAccount($userNameSlug, 'getUserInfoByName');
        $lastdata['result'] = $this->ModelCaller->ContentModel->where('user_id', $user['user_id'])
            ->orderBy('content_id', 'DESC')
            ->limit($this->queryLimitsOrganizer->queryLimit);
        $data['userInfo'] = $user;
        unset($user);
        $gettingdata = $lastdata['result']->getWhere();
        $lastdata['result'] = $gettingdata->getResult();
        // içerikler sıralanıyor.
        foreach ($lastdata['result'] as $key => $contents) {
            $data['contentData'][$contents->content_id] = $contents;
        }
        return $data;
    }
}