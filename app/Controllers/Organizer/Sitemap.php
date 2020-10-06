<?php


namespace App\Controllers\Organizer;


use App\Controllers\BaseController;
use App\Controllers\View\Viewer;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Format\Exceptions\FormatException;

class Sitemap extends BaseController
{

    /**
     * @var Viewer
     */
    public $dynamicViewer;

    public function __construct()
    {
        $this->dynamicViewer = new Viewer();
    }

    // Eğer $index true ise sitemap index için çalışacaktır
    // parametrenin false gönderilmesi durumunda urlset yani içerikler için format düzenleyici devreye girecektir.
    private function XMLGenerator($index = true)
    {
        // this code getting and modified XMLFormatter.php

        // SimpleXML is installed but default
        // but best to check, and then provide a fallback.
        if (!extension_loaded('simplexml')) {
            // never thrown in travis-ci
            // @codeCoverageIgnoreStart
            throw FormatException::forMissingExtension();
            // @codeCoverageIgnoreEnd
        }
        $XML = '<?xml version="1.0" encoding="utf-8"?>
        <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
             http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"></sitemapindex>
             ';
        if ($index === false) {
            $XML = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
             http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"></urlset>
             ';
        }
        return new \SimpleXMLElement($XML);
    }

    //--------------------------------------------------------------------

    /**
     * A recursive method to convert an array into a valid XML string.
     *
     * Written by CodexWorld. Received permission by email on Nov 24, 2016 to use this code.
     *
     * @see http://www.codexworld.com/convert-array-to-xml-in-php/
     * @param $data
     * @param $XMLOutput
     * @param string $yearOrMonth
     * @param bool $isUrl
     */

    private function XMLLooper($data, &$XMLOutput, $yearOrMonth = '', $isUrl = false)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key) && $key != 'created_at') {
                    $subnode = $XMLOutput->addChild("$key");
                    $this->XMLLooper($value, $subnode, $yearOrMonth);
                } else {
                    $subnode = $XMLOutput->addChild($isUrl === false ? "sitemap" : "url");
                    $this->XMLLooper($value, $subnode, $yearOrMonth);
                }
            } else {
                if (!empty($data['loc']) && $data['loc'] != 'No content') {
                    if ($key == 'lastmod') {
                        $date = new \DateTime($data['lastmod']);
                        $value = $date->format('c');
                    }
                    $betweenWay = '';
                    if ($key == 'loc') {
                        if ($yearOrMonth == 'YEAR') {
                            $betweenWay = '/sitemap/' . explode('-', $data['created_at'])[0] . '-' . explode('-', $data['created_at'])[1] . '.xml';
                            unset($data['created_at']);
                        } else {
                            $betweenWay = '/content/' . $value;
                        }
                    }
                    if ($key != 'created_at') {
                        $XMLOutput->addChild("$key", htmlspecialchars($key == 'loc' ? base_url() . $betweenWay : "$value"));
                    }
                } else {
                    exit();
                }
            }
        }
        // Görüntüleme başlığımızın xml olduğunu bildiriyoruz.
        $this->response->setHeader('Content-Type', "application/xml; charset=UTF-8");
    }

    private function mapResolver($result, $isUrl = false)
    {
        $cleanData = [];
        if (!empty($result) && $isUrl === false) {
            foreach ($result as $key => $value) {
                foreach ($value as $subKey => $subValue) {
                    $cleanData[$key . $subKey]['created_at'] = $key . '-' . $subKey;
                    $cleanData[$key . $subKey]['loc'] = $subValue['loc'];
                    $cleanData[$key . $subKey]['lastmod'] = !empty($subValue['lastmod']) ? $subValue['lastmod'] : $subValue['created_at'];

                }
            }
            return $cleanData;
        } elseif (!empty($result)) {
            foreach ($result as $key => $value) {
                if (empty($value['lastmod'])) {
                    $result[$key]['lastmod'] = $value['created_at'];
                }
            }
            return $result;
        } else {
            $result['loc'] = 'No content';
            $result['lastmod'] = 'No modification';
            return $result;
        }
    }

    private function yearWithMonths($createdAtYear, $Content)
    {
        $createdAtYearMonths = [];
        // $createdAtYear dizisinde bulunan yıllara ait içerikleri ay bazında çağırıyoruz
        // ve ayları azalan şekilde sıralıyoruz..
        foreach ($createdAtYear as $value) {
            $tmpVal = $value['createdAt'];
            $createdAtYearMonths[$tmpVal] = $Content
                ->select('MONTH(`created_at`) as createdAtMonth')->distinct(true)
                ->where('YEAR(`created_at`)', $tmpVal)
                ->orderBy('createdAtMonth', 'DESC')
                ->getWhere()
                ->getResultArray();
        }
        return $createdAtYearMonths;
    }

    private function maxDetection($Content, $key, $value)
    {
        $createdTemp = $Content->selectMax('created_at')
            ->where('YEAR(`created_at`)', $key)
            ->where('MONTH(`created_at`)', $value['createdAtMonth'])
            ->getWhere()
            ->getResultArray()[0];
        $updatedemp = $Content->selectMax('updated_at')
            ->where('YEAR(`created_at`)', $key)
            ->where('MONTH(`created_at`)', $value['createdAtMonth'])
            ->getWhere()
            ->getResultArray()[0];
        $tempkey = [];
        if ($createdTemp['created_at'] < $updatedemp['updated_at']) {
            $tempkey['updated_at'] = $updatedemp['updated_at'];
        } else {
            $tempkey['created_at'] = $createdTemp['created_at'];
        }
        return $tempkey;
    }

    private function sitemapResult($createdAtYearMonths, $Content)
    {
        $sitemapResult = [];
        foreach ($createdAtYearMonths as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    // maxDetection bize en son güncellenen içeriği oluşturma tarihi veya güncelleme tarihi olarak
                    // geri döndürmekte ve bu döndürülen değer tempkey değişkenine bir dizi olarak aktarılmakta
                    // $key yıla denk gelmekte $subValue veya $value ise ay a denk gelmektedir.
                    $tempkey = $this->maxDetection($Content, $key, $subValue);
                    $sitemapResult[$key][$subValue['createdAtMonth']] = $Content
                        ->select(['created_at', 'updated_at as lastmod', 'slug as loc'])
                        // array_keys($tempkey)[0] ile maxDetection ile tespit edilen en güncel kolon adını alıyoruz
                        // aynı zamanda bu kolon adı ile değeri alıp eşleştirmede kullanıyoruz
                        ->where(array_keys($tempkey)[0], $tempkey[array_keys($tempkey)[0]])
                        ->getWhere()
                        ->getResultArray()[0];
                }

            } else {
                // Eğer bir dizi değilse burası çalışacaktır.
                $tempkey = $this->maxDetection($Content, $key, $value);
                $sitemapResult[$key][$value['createdAtMonth']] = $Content
                    ->select(['created_at', 'updated_at as lastmod', 'slug as loc'])
                    ->where(array_keys($tempkey)[0], $tempkey[array_keys($tempkey)[0]])
                    ->getWhere()
                    ->getResultArray()[0];
            }
        }
        return $sitemapResult;
    }

    // sitemap.xml de içeriklerin yıla göre dağılımını oluşturuyoruz.
    public function groupContentDateForSiteMap($yearOrMonth = 'YEAR')
    {
        // sitemap.xml dataları..
        $db = db_connect();
        $Content = $db->table('contents');
        // İlk olarak içerik tablomuzdan yıl bazında oluşturulma tarihlerini alıyoruz ve bunları azalan miktarda
        // sıralıyoruz. Sıralanan bilgilerle $createdAtYear değişkeninde bir dizi oluşturuyoruz.
        $createdAtYear = $Content
            ->select('YEAR(`created_at`) as createdAt')->distinct(true)
            ->orderBy('createdAt', 'DESC')
            ->get($this->queryLimitsOrganizer->sitemapLimit)
            ->getResultArray();
        $createdAtYearMonths = $this->yearWithMonths($createdAtYear, $Content);
        $sitemapResult = $this->sitemapResult($createdAtYearMonths, $Content);
        $db->close();
        $result = $this->mapResolver($sitemapResult);
        $XMLOutput = $this->XMLGenerator();
        $this->XMLLooper($result, $XMLOutput, $yearOrMonth);
        return $XMLOutput->asXML();
    }

    // Buradaki sıralamada diğerlerinden farklı olarak gruplama yapmıyoruz. Direk seneye bağlı ayın günlerinde paylaşılan
    // içerikleri gönderiyoruz
    public function getGroupedMonthFromRequest(int $year, int $month)
    {
        $db = db_connect();
        $Content = $db->table('contents');
        $result = $Content
            ->select(['slug as loc', 'updated_at as lastmod', 'created_at'])
            ->where('YEAR(`created_at`)', $year)
            ->where('MONTH(`created_at`)', $month)
            ->orderBy('lastmod', 'DESC')
            ->get($this->queryLimitsOrganizer->sitemapLimit)
            ->getResultArray();
        $db->close();
        $result = $this->mapResolver($result, true);
        if ($result['loc'] === 'No content') {
            throw PageNotFoundException::forPageNotFound();
        }
        $XMLOutput = $this->XMLGenerator(false);
        $this->XMLLooper($result, $XMLOutput, '', true);
        return $XMLOutput->asXML();
    }
}