<?php namespace App\Filters;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PublicRequest implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
        helper(['form']);
        // Herkese açık profil sorgularında herhangibir güvenlik açığı meydana gelmemesi için
        // Uygulanan filtre..
        if($request->uri->getSegment(1) == 'profile'){
            $original = $request->uri->getSegment(2);
            $filtered = esc($original);
            if (strlen($original) !== strlen($filtered)){
                throw PageNotFoundException::forPageNotFound();
            }
        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}