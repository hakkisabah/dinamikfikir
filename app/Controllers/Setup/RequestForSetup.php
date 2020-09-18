<?php


namespace App\Controllers\Setup;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RequestForSetup extends BaseController
{
    protected $request;
    protected $response;

    public function __construct(RequestInterface $request,ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

}