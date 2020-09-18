<?php
// Require the Composer autoloader.
require 'aws/aws-autoloader.php';

use App\Controllers\ConstantBase;
use \GuzzleHttp\Promise\Promise;

class AwsS3
{

    private $s3;
    public $ConstantBase;

    public function __construct()
    {
        // Instantiate an Amazon S3 client.
        if (getenv('SETUP') != 'ON') {
            $this->s3 = new Aws\S3\S3Client([
                'version' => 'latest',
                'region' => getenv('AWS_REGION'),
                'credentials' => array(
                    'key' => getenv('AWS_ACCESKEYID'),
                    'secret' => getenv('AWS_SECRETKEY')
                )
            ]);
        }

        $this->ConstantBase = new ConstantBase();
    }

    public function transferAssets($setupKeys = [])
    {
        $client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => !empty($setupKeys['aws_region'])?$setupKeys['aws_region']:getenv('AWS_REGION'),
            'credentials' => array(
                'key' => !empty($setupKeys['aws_acceskeyid'])?$setupKeys['aws_acceskeyid']:getenv('AWS_ACCESKEYID'),
                'secret' => !empty($setupKeys['aws_secretkey'])?$setupKeys['aws_secretkey']:getenv('AWS_SECRETKEY')
            )
        ]);
        // Where the files will be source from
        $whichDir = ROOTPATH ?? __DIR__;
        $source = $whichDir . 'public/assets';

// Where the files will be transferred to
        // $bucketname parameteres coming from Setup.php
        $whichBucket = !empty($setupKeys['aws_bucketname'])?$setupKeys['aws_bucketname']:$this->ConstantBase->ConstantInfo->AwsS3BucketName;
        $dest = 's3://'.$whichBucket.'/public/assets';

// Create a transfer object
        $manager = new \Aws\S3\Transfer($client, $source, $dest, [
            'before' => function (\Aws\Command $command) {
                $command['ACL'] = 'public-read';
            }
        ]);

// Perform the transfer synchronously

        $manager->transfer();
        unset($client);
        return true;

    }

    public function checkAWSaccountInfo()
    {

        if (
            !empty(getenv('AWS_REGION'))
            &&
            !empty(getenv('AWS_ACCESKEYID'))
            &&
            !empty(getenv('AWS_SECRETKEY'))
            &&
            !empty(getenv('AWS_BUCKET_NAME'))
            &&
            !empty(getenv('REMOTE_PUBLIC_BASE_ADDRESS'))

        ) {
            return true;
        } else {
            $EnvSetter = new \App\Controllers\Organizer\EnvSetter();
            $data = ['aws_system' => 'OFF'];
            $EnvSetter->envWriter('.env', $EnvSetter->siteConfDetector($data));
            return false;
        }

    }

    public function testSetup($setupKeys)
    {
        try {
            $testS3 = new Aws\S3\S3Client([
                'version' => 'latest',
                'region' => $setupKeys['aws_region'],
                'credentials' => array(
                    'key' => $setupKeys['aws_acceskeyid'],
                    'secret' => $setupKeys['aws_secretkey']
                )
            ]);
        } finally {
            if ($testS3) {
                $result = $testS3->putObject([
                    'Bucket' => $setupKeys['aws_bucketname'],
                    'Key' => 'NotDeleteThisTestTextForDinamikfikirAWS.txt',
                    'Body' => file_get_contents('NotDeleteThisTestTextForDinamikfikirAWS.txt'),
                    'ACL' => 'public-read',
                ]);
                if ($result) {
                    $result = $testS3->getObject([
                        'Bucket' => $setupKeys['aws_bucketname'],
                        'Key' => 'NotDeleteThisTestTextForDinamikfikirAWS.txt'
                    ]);
                    return $result['Body'];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


    public function getObject($fileName)
    {
        $result = $this->s3->getObject([
            'Bucket' => $this->ConstantBase->ConstantInfo->AwsS3BucketName,
            'Key' => $this->ConstantBase->ConstantInfo->imageFolderBase . $fileName
        ]);
        return $result['Body']->getContents();
    }

    public function uploadAwsImage($base64, $fileName)
    {
        // Upload a publicly accessible file. The file size and type are determined by the SDK.
        try {
            $this->s3->putObject([
                'Bucket' => $this->ConstantBase->ConstantInfo->AwsS3BucketName,
                'Key' => $this->ConstantBase->ConstantInfo->imageFolderBase . $fileName,
                'Body' => $base64,
                'ACL' => 'public-read',
            ]);
            return true;
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }
    }


    public function deleteImage($fileName)
    {
        try {
            $this->s3->deleteObject([
                'Bucket' => $this->ConstantBase->ConstantInfo->AwsS3BucketName,
                'Key' => $this->ConstantBase->ConstantInfo->imageFolderBase . $fileName,
            ]);
            return true;
        } catch (Aws\S3\Exception\S3Exception $e) {
            return false;
        }
    }

    public function __destruct()
    {
        unset($this->s3);
    }
}