<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Localization implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // herhangi bir dile karşılık gelmez ise listenin en başındaki dil geçerli olur..
        $supported = [
            'en',
            'tr'
        ];
        $negotiate = \Config\Services::negotiator();
        $lang = $negotiate->language($supported);
        session()->set('language',$lang);

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}