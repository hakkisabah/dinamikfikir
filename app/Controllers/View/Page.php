<?php


namespace App\Controllers\View;

use App\Controllers\BaseController;
use App\Controllers\Dashboard\Content;
use App\Controllers\Dashboard\Dashboard;
use App\Controllers\Requests\UserRequest;
use App\Controllers\Session;
use App\Controllers\SharedData\SharedData;

class Page extends BaseController implements Pages
{

    /**
     * @var Viewer
     */
    public $dynamicViewer;

    public $SharedData;

    public $SessionController;

    public function __construct()
    {

        $this->dynamicViewer = new Viewer();
        $this->SharedData = new SharedData();
        $this->SessionController = new Session();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function home()
    {

        return $this->dynamicViewer->homeIndex();
    }

    public function KVKK()
    {
        return $this->dynamicViewer->KVKK();
    }

    public function adminReport()
    {
        return $this->dynamicViewer->adminReport();
    }

    public function adminSite()
    {

        return $this->dynamicViewer->adminSite();
    }

    public function adminUsers()
    {

        return $this->dynamicViewer->adminUsers();
    }

    public function adminContents()
    {

        return $this->dynamicViewer->adminContents();
    }

    /**
     * @return mixed
     */
    public function dashboardIndex()
    {
        return $this->dynamicViewer->dashIndex();
    }

    /**
     * @return mixed
     */
    public function contents()
    {
        return $this->dynamicViewer->dashContents();
    }

    public function editor($slug = false)
    {
        if ($slug) {
            $Content = new Content();
            $lastdata = (new Dashboard())->editcontent(
                $Content->getContent('slug', $slug)
            );
            unset($Content);
            if ($lastdata != false) {
                return $this->dynamicViewer->dashEditor($lastdata);
            } else {
                return redirect()->to('/dashboard/editor');
            }
        } else {
            $data['currentBase'] = base_url() . '/';
            return $this->dynamicViewer->dashEditor($data);
        }


    }


    /**
     * @return mixed
     */
    public function login()
    {

        helper(['form']);
        if ($this->SessionController->getSession('userInfo')) {
            return redirect()->to('/dashboard');
        } else {
            $this->SessionController->setSession('loginPage', true);
            $this->dynamicViewer->login();
            $this->SessionController->removeSession('loginPage');
        }

    }

    public function forgot()
    {
        return $this->dynamicViewer->forgot();
    }

    /**
     * @return mixed
     */
    public function register()
    {
        helper(['form']);
        if ($this->SessionController->getSession('userInfo')) {
            return redirect()->to('/users/login');
        } else {
            $this->SessionController->setSession('registerPage', true);
            $this->dynamicViewer->register();
            $this->SessionController->removeSession('registerPage');
        }
    }

    /**
     * @return mixed
     */
    public function profile()
    {
        $data = [];
        helper(['form']);
        $userReq = new UserRequest();
        $data['user'] = $userReq->getAccount(
            session()->get('userInfo')['user_name'],
            'getUserInfoByName'
        );
        unset($userReq);
        if (isset($data['user'])) {
            $this->dynamicViewer->profile($data);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }

    }

    /**
     * @param string $userNameSlug
     * @return mixed
     */
    public function publicProfile(string $userNameSlug)
    {
        $user = $this->SharedData->getPublicUserInfo($userNameSlug);
        if ($user) {
            $this->dynamicViewer->publicUser($user);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }

    }

    public function publiccontent(string $slug)
    {
        $publicContent = $this->SharedData->getPublicContent('slug', $slug);

        if ($publicContent !== false) {
            return $this->dynamicViewer->publicContent($publicContent);
        } else {
           throw PageNotFoundException::forPageNotFound($message = 'Not Find');
        }
    }

    public function robots()
    {

    }
    public function __destruct()
    {
        unset($this->SharedData);
    }
}