<?php namespace App\Filters;

use App\Controllers\Organizer\ModelCaller;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

// Ownership Filters.php de $filters değişkeninde ayrıca belirlenmiştir..
class Ownership implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ModelCaller = new ModelCaller();

        // User information Ownership checker
        if ($request->getMethod() == 'post') {
            // User..
            // Profile update checker
            if ($request->uri->getSegment(2) == 'profile') {
                return $this->checker(
                    $ModelCaller->UserModel,
                    'user_name',
                    $request->getVar('user_name')
                );
            }
            // Content..
            // Content update checker
            if ($request->uri->getSegment(2) == 'updatecontent') {
                return $this->checker(
                    $ModelCaller->ContentModel,
                    'content_id',
                    strip_tags($request->getVar('contentId'))
                );
            }
        } else {
            if ($request->getMethod() == 'get') {
                // Content Ownership checker
                if ($request->uri->getSegment(2) === 'editor') {
                    return $this->checker(
                        $ModelCaller->ContentModel,
                        'slug',
                        strip_tags($request->uri->getSegment(3))
                    );
                }

                if ($request->uri->getSegment(1) === 'deletecontent') {
                    return $this->checker(
                        $ModelCaller->ContentModel,
                        'slug',
                        strip_tags($request->uri->getSegment(2))
                    );
                }
                if ($request->uri->getSegment(1) === 'comment' && $request->uri->getSegment(2) === 'delete') {
                    // Burada ek olarak içerik sahibininde yorumu silme hakkı olacağı için $ModelCaller->ContentModel
                    // parametresini son parametre olarak gönderiyoruz.
                    return $this->checker(
                        $ModelCaller->CommentModel,
                        'comment_id',
                        strip_tags($request->uri->getSegment(3)),
                        $ModelCaller->ContentModel
                    );
                }

            }

        }
    }

    private function checker($Model, $whereKey, $whereParam, $Model2 = false)
    {
        $OwnerShip = $Model->where($whereKey, $whereParam)->find();
        // Yorum silme işlemi hem içerik sahibine hemde yorum sahibine silme yetkisini verebilmek adına
        // $Model2 parametresinde bulunan içerik sorgulama modelini kullanıyoruz.
        if ($whereKey === 'comment_id' && !empty($OwnerShip[0]['user_id'])) {
            $Content = $Model2->where('content_id', $OwnerShip[0]['content_id'])->find();
            if (
                empty($Content) ||
                // Eğer gelen istekteki sahiplik sorgusunda yorum ve içerik sahibinin kullanıcı kimlikleri
                // uyuşmuyorsa bu işlem yapılmadan hata gönderilir..
                ($OwnerShip[0]['user_id'] != session()->get('userInfo')['user_id']
                    &&
                    $Content[0]['user_id'] != session()->get('userInfo')['user_id'])
            ) {
                throw PageNotFoundException::forPageNotFound();
            }
        }
        if ($whereKey !== 'comment_id' && !empty($OwnerShip[0]['user_id']) && $OwnerShip[0]['user_id'] != session()->get('userInfo')['user_id']) {
            throw PageNotFoundException::forPageNotFound();
        }
        if (empty($OwnerShip[0]['user_id'])) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}