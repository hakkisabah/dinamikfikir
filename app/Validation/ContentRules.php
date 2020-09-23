<?php


namespace App\Validation;

use App\Controllers\DashboardBase;

class ContentRules
{
    private $Dasboard;
    private $currentRequest;

    public function __construct()
    {
        $this->currentRequest = service('request');
        $this->Dasboard = new DashboardBase();

    }

    public function validateContentSlug(string $str, string $fields, array $data)
    {

        $sluggedTitle = $this->Dasboard->Content->slugify($data['title']);
        $isSlug = $this->Dasboard->Content->getContent('slug', $sluggedTitle);
        // Eğer daha önceden benzer başlık açmış ise sahipliği kontrol edilir
        // Eğer sahibi tarafından aynı başlığa bir güncelleme yapılıyorsa buna izin verilir
        // Eğer yeni bir başlık farklı bir sahiplik tarafından kullanılıyorsa sonuç false olarak dönecektir
        // Eğer hiç kayıt yoksa işlem için uygun anlamına gelir..
        if ($sluggedTitle === false){
            return false;
        }
        if ($isSlug != false) {
            if (
                $isSlug['user_id'] == session()->get('userInfo')['user_id']
                &&
                $isSlug['slug'] == $sluggedTitle
                &&
                // Yeni kayıt eklerken içerik sahibinde aynı başlık var ise buna engel olunur..
                // bununla birlikte updatecontent uç noktasındaki işlevin
                // buradaki slug konusunu etkilemeyeceği nettir. != 'addcontent' şartı bunu bize açıklamaktadır..
                // bu şart ile birlikte daha da açıcak olursak bu doğrulama sadece içerik eklerken
                // başlık kontrolü esnasında çalışmakta dolayısıyla sadece içerik eklerken veya güncellerken çalışmakta
                // yani en fazla iki farklı işlemde bu kod bloğu devreye girmekte..
                // biz bunun birtanesini yani 'addcontent' kısmını iptal ettiğimizde sadece güncelleme işleminde sadece
                // daha önceden açılmış başlıklar üzerinde işlem yapabilmemiz sağlanmış oldu..
                $this->currentRequest->uri->getSegment(2) != 'addcontent'
            ) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function __destruct()
    {
        unset($this->Dasboard);
        unset($this->currentRequest);
    }
}