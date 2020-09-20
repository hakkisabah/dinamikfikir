<?php


namespace App\Controllers\Organizer;


use App\Controllers\Constant\EnvConstants;

class EnvSetter
{
    private $siteConfKeys;
    public function __construct()
    {
        $this->siteConfKeys = new EnvConstants();
        $this->siteConfKeys = $this->siteConfKeys->envConst;
    }

    public function envWriter($fileName, $detected,$chmod = true)
    {
        if (file_exists($fileName)) {
            $env = file_get_contents($fileName);
            $lines = file($fileName);
            foreach ($lines as $lineNumber => $line) {
                foreach ($detected as $key => $value) {
                    if (strpos($line, $key . ' =') !== false) {
                        $env = str_replace($line, $key . " = '$value' \n", $env);
                    }
                }
            }
            $fileperm = substr(sprintf("%o", fileperms($fileName)), -4);
            if ($chmod !== false){
                if ($fileperm != 0600) {
                    try {
                        chmod($fileName, 0600);
                    }catch (\Exception $e){
                        file_put_contents(getcwd() .'/.env', file_get_contents(getcwd() . '/.env_default'));
                        echo "PERMISSON FAILED ! (FROM EnvSetter.php)";
                        throw new \CodeIgniter\Exceptions\ConfigException();
                    }
                }
            }
            try {
                file_put_contents($fileName, $env);
            }catch (\Exception $e){
                echo "PERMISSON FAILED 2 ! (FROM EnvSetter.php)";
                exit();
            }
            return true;
        }
    }
    public function siteConfDetector($updatingSiteConf)
    {
        // isset ile empty arasındaki fark ;
        // Örneğin, bir dizi anahtarı sorguluyorsunuz isset o dizide o anahtar var mı yok mu diye bakar varsa true döner
        // empty ise o dizinin anahtarına ait değişken hafızasını kontrol eder yani dizi ye ait anahtarın içeriği boş mu dolu mu diye bakar..
        // bu yüzden burada !empty yerine sadece amaca yönelik isset kullanılmıştır
        $data = [];
        foreach ($this->siteConfKeys as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    if (is_array($subValue)) {
                        foreach ($subValue as $rootKey => $rootValue) {
                            if (isset($updatingSiteConf[$rootKey])) {
                                $data[$rootValue] = $updatingSiteConf[$rootKey];
                            }
                        }
                    } else {
                        if (isset($updatingSiteConf[$subKey])) {
                            $data[$subValue] = $updatingSiteConf[$subKey];
                        }
                    }
                }
            } else {
                if (isset($updatingSiteConf[$key])) {
                    $data[$value] = $updatingSiteConf[$key];
                }
            }
        }
        return $data;
    }

    public function __destruct()
    {
        unset($this->siteConfKeys);
    }
}