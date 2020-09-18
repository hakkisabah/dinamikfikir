<?php


namespace App\Controllers\Extension;

use App\Controllers\ConstantBase;
use AwsS3;

class Uploader
{

    private function awsReturner()
    {
        return (new AwsS3());
    }

//    public function prepareImage($imageData)
//    {
//        $extType = $imageData->getExtension();
//        $postedImage = file_get_contents($imageData->getTempName());
//        return 'data:image/' . $extType . ';base64,' . base64_encode($postedImage);
////        $this->awsReturner()->upload(file_get_contents($base64));
//    }

    public function uploadImage($imageData)
    {
        $fileRandomName = $imageData->getRandomName(); // getRandomName method automatic finding and generating file extension

        if (getenv('UPLOAD_LOCATION') != 'LOCAL') {
            $postedImage = file_get_contents($imageData->getTempName());
            $uploadedImage = $this->awsReturner()->uploadAwsImage($postedImage, $fileRandomName);
            if ($uploadedImage) {
                unset($uploadedImage);
                return $fileRandomName;
            } else {
                unset($uploadedImage);
                return false;
            }
        } else {
            $this->uploadFolderChecker((new ConstantBase())->ConstantInfo->localStateReal);
            $uploadedImage = $imageData->move((new ConstantBase())->ConstantInfo->localStateReal, $fileRandomName);
            // Sonuç başarılı olduğunda cevap 1 döner.
            if ($uploadedImage == 1) {
                return $fileRandomName;
            } else {
                return false;
            }
        }
    }

    public function deleteImage($imageName)
    {
        if (getenv('UPLOAD_LOCATION') != 'LOCAL') {
            return $this->awsReturner()->deleteImage($imageName);
        } else {
            $file = (new ConstantBase())->ConstantInfo->localStateReal . $imageName;
            if (is_file($file)) {
                unlink($file);
                return true;
            } else {
                return false;
            }
        }
    }

    private function uploadFolderChecker($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function changeLocation(array $names)
    {
        $this->uploadFolderChecker((new ConstantBase())->ConstantInfo->localStateReal);
        $localDir = (new ConstantBase())->ConstantInfo->remoteStateReal;
        // Dikkat, buradaki mantıksal sorgulamada görsellerin yeri zıt yönde değiştirilecektir..
        // Yerel depolamada bulunan bir görsel uzaktaki sunucuya veya uzaktaki görsel yerel depolama lokasyonunda
        // kaydedilir böylece herhangibir görsel link hatasının önüne geçilmiş olur..
        // $localDir değişkeni istenilen dosyayı bulup uzağa yüklemede ve yereldeki lokasyona yüklemede gereklidir

        if (getenv('UPLOAD_LOCATION') != 'LOCAL') {
            if (!empty($names['editor'])) {
                foreach ($names['editor'] as $key => $value) {
                    if (is_file($localDir . $value)) {
                        $isOk = $this->awsReturner()->uploadAwsImage(file_get_contents($localDir . $value), $value);
                        if ($isOk) {
                            unlink($localDir . $value);
                            $names['editor'][$key] = true;
                        }
                    }
                }
            }
            if (!empty($names['title'])) {
                if (is_file($localDir . $names['title'])) {

                    $isOk = $this->awsReturner()->uploadAwsImage(file_get_contents($localDir . $names['title']), $names['title']);
                    if ($isOk) {
                        unlink($localDir . $names['title']);
                        $names['title'] = true;
                    }

                }
            }
            return $names;
        } else {
            if (!empty($names['editor'])) {
                foreach ($names['editor'] as $key => $value) {

                    $isOk = file_put_contents($localDir . $value, $this->awsReturner()->getObject($value));
                    if ($isOk) {
                        $this->awsReturner()->deleteImage($value);
                        $names['editor'][$key] = true;
                    }

                }
            }
            if (!empty($names['title'])) {
                $isOk = file_put_contents($localDir . $names['title'], $this->awsReturner()->getObject($names['title']));
                if ($isOk) {
                    $this->awsReturner()->deleteImage($names['title']);
                    $names['title'] = true;
                }

            }
        }
        return $names;

    }


}