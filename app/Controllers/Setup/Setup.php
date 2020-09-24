<?php


namespace App\Controllers\Setup;


use App\Controllers\Email\SmtpEmail;
use App\Controllers\Organizer\EnvSetter;
use App\Controllers\Setup\Database\Migrations\ForgeMaster;
use App\Controllers\User\User;
use App\Controllers\Validate\Validator;
use App\Models\UserModel;
use AwsS3;

class Setup extends RequestForSetup
{

    public function __construct()
    {
        parent::__construct(service('request'), service('response'));

    }

    public function detecRequest()
    {
        $uri = service('uri');
        $segments = $uri->getSegments();
        if ($this->request->getMethod() == 'post' && $segments[0] == 'setup' && $segments[1] == 'testdbforsetup') {
            return print_r(json_encode($this->dbConnectionChecker($this->request->getPost())));
        } elseif ($this->request->getMethod() == 'post' && $segments[0] == 'setup' && $segments[1] == 'testmailforsetup') {
            return print_r(json_encode($this->testMailForSetup($this->request)));
        } elseif ($this->request->getMethod() == 'post' && $segments[0] == 'setup' && $segments[1] == 'createadminforsetup') {
            return print_r(json_encode($this->createAdminForSetup($this->request)));
        } elseif ($this->request->getMethod() == 'post' && $segments[0] == 'setup' && $segments[1] == 'savesetup') {
            return print_r(json_encode($this->saveSetup($this->request)));
        } elseif ($this->request->getMethod() == 'post' && $segments[0] == 'setup' && $segments[1] == 'testawsforsetup') {
            return print_r(json_encode($this->testAwsForSetup($this->request)));
        } else {
            return $this->checkEnvDb();
        }
    }

    private function getDbLoginInfo()
    {
        return [
            'DSN' => '',
            'hostname' => getenv('database.default.hostname'),
            'username' => getenv('database.default.username'),
            'password' => getenv('database.default.password'),
            'database' => getenv('database.default.database'),
            'DBDriver' => getenv('database.default.DBDriver'),
            'DBPrefix' => '',
            'pConnect' => FALSE,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'cacheOn'  => FALSE,
            'cacheDir' => '',
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => FALSE,
            'compress' => FALSE,
            'strictOn' => FALSE,
            'failover' => [],
        ];
    }

    public function checkEnvDb()
    {
        if (getenv('SETUP') == 'ON'){
            $result = $this->dbConnectionChecker($this->getDbLoginInfo());
            if ($result['worked'] != 1) {
                return $this->setupPage();
            } else {
                if ($result['worked'] == 1) {
                    // Eğer bir hesap yöneticisi belirlemeden kurulumdan ayrılıp tekrar gelindiyse kullanıcı sorgulanır..
                    $adminChecker = new UserModel();
                    $result = $adminChecker->where('role', 'admin')->find();
                    if (!$result) {
                        return $this->setupPage();
                    } else {
                        $setupIsCompleted['setup'] = 'OFF';
                        $this->setupCloser($setupIsCompleted, true);
                        return redirect()->to('/admin/site');
                    }

                }
            }
        }else{
            return redirect()->to('/admin/site');
        }
    }

    private function setupPage()
    {
        $data = ['setup' => getenv('SETUP')];
        echo view('setup/index', $data);
    }

    public function setupCloser($setupIsCompleted, $chmod)
    {
        $fileName = '.env';
        $EnvSetter = new EnvSetter();
        if ($EnvSetter->envWriter($fileName, $EnvSetter->siteConfDetector($setupIsCompleted), $chmod)) {
            return true;
        }
    }

    public function saveSetup($request)
    {
        $setupIsCompleted = $request->getPost();
        $setupIsCompleted['mail_name'] = lang('View.setup.defaultMailEnv.MAIL_NAME');
        $setupIsCompleted['mail_default_subject'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_SUBJECT');
        $setupIsCompleted['mail_default_welcome'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_WELCOME');
        $setupIsCompleted['mail_default_link_text'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_LINK_TEXT');
        $setupIsCompleted['mail_default_alternative_text'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT');
        $setupIsCompleted['mail_default_alternative_text2'] = lang('View.setup.defaultMailEnv.MAIL_DEFAULT_MESSAGE_ALTERNATIVE_TEXT2');
        $setupIsCompleted['aws_remotepublicaddress'] = rtrim($setupIsCompleted['aws_remotepublicaddress'],'/');
        $setupIsCompleted['setup'] = 'OFF';
        $this->setupCloser($setupIsCompleted, true);
        return ['worked' => true, 'name' => 'setup'];
    }

    private function createDatabases($forge)
    {

        (new ForgeMaster($forge));
        file_put_contents('robots.txt',$this->robotsFileString());
        return true;

    }

    public function dbConnectionChecker($conf)
    {
        $conf = [
            'DSN' => '',
            'hostname' => $conf['hostname'],
            'username' => $conf['username'],
            'password' => $conf['password'],
            'database' => $conf['database'],
            'DBDriver' => $conf['DBDriver'],
            'DBPrefix' => '',
            'pConnect' => FALSE,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'cacheOn'  => FALSE,
            'cacheDir' => '',
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => FALSE,
            'compress' => FALSE,
            'strictOn' => FALSE,
            'failover' => [],
        ];
        try {
            $this->setupCloser($conf, false);
            $db = \Config\Database::connect($conf);
            $dbC = $db->connect();
            $forge = \Config\Database::forge($db);
            $this->createDatabases($forge);
        } finally {
            if (!empty($dbC->client_info)) {
                return ['worked' => true, 'name' => 'db'];
            } else {
                return ['worked' => false];
            }
        }
    }

    public function testMailForSetup($request)
    {
        $data = [];
        if (!empty($request->getVar('test_mail_input'))) {
            $data = $request->getPost();
            $data['setTo'] = $request->getVar('test_mail_input');
            unset($data['test_mail_input']);
        } else {
            return ['worked' => false];
        }
        $SmtpEmail = new SmtpEmail();
        $data['mail_from'] = $request->getVar('mail_smtp_user');
        $data['mail_system'] = 'ON';
        $data['mail_default_subject'] = getenv('SITE_NAME') . ' ' . lang('View.setup.defaultMailEnv.MAIL_DEFAULT_SUBJECT');
        $data['mail_name'] = getenv('SITE_NAME') . ' ' . lang('View.setup.defaultMailEnv.MAIL_NAME');
        $this->setupCloser($data, false);
        $data['setMessage'] = 'test';
        $data['setSubject'] = 'test';
        if ($SmtpEmail->testMail($data)) {
            return ['worked' => 1, 'name' => 'mail'];
        } else {
            return ['worked' => false];
        }
    }

    public function createAdminForSetup($request)
    {
        $data = $request->getPost();
        $data['firstname'] = 'Site';
        $data['lastname'] = 'Administrator';
        $data['email_status'] = 1;
        $data['icon_name'] = 'blank.svg';
        $data['role'] = 'admin';
        $userM = new UserModel();

        $subValidator = new Validator();
        $validate = $subValidator->createAdminValidatorForSetup();
        if (!$this->validate($validate['rules'], $validate['errors'])) {
            $result = $this->validator->listErrors();
            return ['worked' => 0, 'name' => 'adminUser', 'error' => $result];
        }

        $result = $userM->insert($data);

        if (!empty($result)) {
            unset($userM);
            return ['worked' => 1, 'name' => 'adminUser'];
        } else {
            return ['worked' => 0];
        }

    }

    public function testAwsForSetup($request)
    {
        $awsInfos = $request->getPost();
        $awsS3 = new AwsS3();
        $awsInfos['aws_remotepublicaddress'] = rtrim($awsInfos['aws_remotepublicaddress'],'/');
        $result = $awsS3->testSetup($awsInfos);

        if ($result) {
            $awsInfos['aws_system'] = 'ON';
            $this->setupCloser($awsInfos, false);
            $awsS3->transferAssets($awsInfos);
            unset($awsS3);
            return ['worked' => 1, 'name' => 'aws'];
        } else {
            return ['worked' => 0];
        }

    }

    private function robotsFileString()
    {
        return 'User-agent: *
Allow: /
Allow: /content/
Allow: /profile/
Disallow: /users/login/
Disallow: /users/register/
Disallow: /users/forgot/
Disallow: /dashboard/
Disallow: /admin/
Disallow: /index.php
Disallow: /*.php$
Disallow: /*.js$
Disallow: /*.css$
Disallow: */feed/
Disallow: */trackback/
Sitemap : '. base_url().'/sitemap.xml';
    }
}