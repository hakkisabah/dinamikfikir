<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class setupDetector implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
        if(getenv('SETUP') != 'ON'){
            $response = service('response');
            return $response->setStatusCode(200)->setJSON(['setup' => false]);
        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here

    }

}