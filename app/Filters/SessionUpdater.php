<?php

namespace App\Filters;

use App\Controllers\Organizer\Organizer;
use App\Controllers\Session;
use App\Controllers\Requests\UserRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionUpdater implements FilterInterface
{

    public function before(RequestInterface $request)
    {
        $this->updater();
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        $this->updater();
    }

    private function updater()
    {
        $localSession = new Session();
//        $Organizer = new Organizer();
//       session()->set('userData', $Organizer->internalCall()['result']);
//        unset($Organizer);
        $User = new UserRequest();
        $localSession->setSession('userInfo',
            $User->getAccount(
                $localSession->getSession('userInfo')['user_id'],
                'getUserInfoById'
            )
        );
        unset($User);
    }
}