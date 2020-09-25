<?php namespace App\Filters;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class XMLChecker implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
        $paths = explode('/',$request->uri->getPath());
        if ($paths[0] == 'sitemap' && !empty($paths[1])){
            $truePath = explode('.',$paths[1]);
            if (strip_tags($truePath[0]) != $truePath[0]){
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