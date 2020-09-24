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
        if ($paths[0] == 'sitemap' && $paths[1] == 'year' && empty($paths[3])){
            if (strip_tags($paths[2]) != $paths[2]){
                throw PageNotFoundException::forPageNotFound();
            }
        }
        if ($paths[0] == 'sitemap' && $paths[1] == 'year' && !empty($paths[2]) && $paths[3] == 'month' && !empty($paths[4])){
          $month = explode('.',$paths[4]);
          if (!empty($month[0]) && strlen($month[0]) > 2){
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