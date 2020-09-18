<?php namespace App\Filters;

use App\Models\IpTables;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IpAndLocationLogger implements FilterInterface
{
    public function before(RequestInterface $request)
    {

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        if ((getenv('SETUP') != 'ON') && (getenv('LOG_WITH_DB') == 'ON' || getenv('LOG_WITH_FILE') == 'ON')) {
            if (!session()->get('userInfo')['isLoggedIn']) {
                $this->saveClient($request, 'guest');
            } elseif (session()->get('userInfo')['isLoggedIn']) {
                $this->saveClient($request, session()->get('userInfo')['user_name']);
            }
        }

    }

    private function saveClient($request, $client)
    {

        $ipModel = new IpTables();
        $agent = $request->getUserAgent();
        if ($agent->isBrowser()) {
            $currentAgent = 'Browser ' . $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $currentAgent = 'Robot ' . $agent->robot();
        } elseif ($agent->isMobile()) {
            $currentAgent = 'Mobile ' . $agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }
        helper('cookie');
        $uri = service('uri');
        $isDismiss = get_cookie('cookieconsent_status');
        $userOrGuest = [
            'user_name' => $client,
            'ip_address' => (string)$request->getIPAddress(),
            'user_device_info' => $currentAgent,
            'end_point' => empty($uri->getSegments()) ? '/' : implode("/", $uri->getSegments()),
            'cookie_consent' => !empty($isDismiss) ? 'OK' : 'NOT',
        ];
        if (getenv('LOG_WITH_FILE') == 'ON') {
            foreach ($userOrGuest as $key => $value) {
                log_message('info', 'Client ' . $key . ' => ' . $value, $userOrGuest);
            }
        }

        if (getenv('LOG_WITH_DB') == 'ON') {
            try {
                $ipModel->save($userOrGuest);
            } catch (\ReflectionException $e) {
            }
        }

        unset($uri);
        unset($ipModel);

    }

}