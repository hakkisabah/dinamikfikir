<?php namespace App\Filters;

use App\Controllers\Organizer\EnvSetter;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LocationTimer implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
        $EnvSetter = new EnvSetter();
        $filename = '.env';
        $now = new \DateTime('now');
        $past = getenv('LOCATION_WAIT');
        if ($past !=0){
            $past = new \DateTime($past);
            $isExpired = explode("/",$past->diff($now)->format("%d/%h/%i/%s"));
            if ($isExpired[2]>0 || $isExpired[3]>0 || $isExpired[1]>0 || $isExpired[0]>0 ){
                $data['location_wait'] = 0;
                $EnvSetter->envWriter($filename, $EnvSetter->siteConfDetector($data));
            }else{
                session()->setFlashdata('success',lang('DF_Messages.messages.flashData.userRequest.locationChanges'));
                $uri = service('uri');
                $segments = $uri->getSegments();
                if (($segments[0] == 'dashboard' && $segments[1] == 'updatecontent') || ($segments[0] == 'dashboard' && $segments[1] == 'addcontent')){
                    return redirect()->to(session()->get('editorWaitingLink'))->withInput();
                }
                if (($segments[0] == 'dashboard' && $segments[1] == 'userleaveremovetempimage')){
                    return;
                }

            }

        }

    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {

        // Do something here
    }
}