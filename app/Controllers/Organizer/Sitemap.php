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
        if (! extension_loaded('simplexml'))
        {
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
        if ($index === false){
            $XML ='<?xml version="1.0" encoding="UTF-8"?>
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

    private function XMLLooper($data,&$XMLOutput,$yearOrMonth ='',$isUrl=false)
    {
        foreach ($data as $key => $value)
        {
            if (is_array($value))
            {
                if (! is_numeric($key))
                {
                    $subnode = $XMLOutput->addChild("$key");
                    $this->XMLLooper($value, $subnode,$yearOrMonth);
                }
                else
                {
                    $subnode = $XMLOutput->addChild($isUrl===false?"sitemap":"url");
                    $this->XMLLooper($value, $subnode,$yearOrMonth);
                }
            }
            else
            {
                if ($key == 'lastmod'){
                    $date = new \DateTime($data['lastmod']);
                    $value = $date->format('c');
                }
                $betweenWay ='';
                if ($key == 'loc'){
                    if ($yearOrMonth == 'YEAR'){
                        $betweenWay = '/sitemap/' . explode('-',$data['lastmod'])[0] . '.xml';
                    }else{
                        $betweenWay = '/content/' . $value;
                    }
                }
                $XMLOutput->addChild("$key", htmlspecialchars($key=='loc'? base_url() . $betweenWay:"$value"));
            }
        }
        // Görüntüleme başlığımızın xml olduğunu bildiriyoruz.
        $this->response->setHeader('Content-Type',"application/xml; charset=UTF-8");
    }

    // sitemap.xml de içeriklerin yıla göre dağılımını oluşturuyoruz.
    public function groupContentDateForSiteMap($yearOrMonth = 'YEAR')
    {
        $db = db_connect();
        $Content = $db->table('contents');
        $result =  $Content
            ->select(['slug as loc','created_at as lastmod'])
            ->orderBy('YEAR(`created_at`)', 'DESC')
            ->groupBy($yearOrMonth . '(`created_at`)')
            ->get($this->queryLimitsOrganizer->sitemapLimit)
            ->getResultArray();
        $db->close();
        if (empty($result)) {
            $result['slug'] = 'No content';
            $result['lastmod'] = 'No modification';
        }
        $XMLOutput = $this->XMLGenerator();
        $this->XMLLooper($result, $XMLOutput,$yearOrMonth);
        return $XMLOutput->asXML();
    }

    // Buradaki sıralamada diğerlerinden farklı olarak gruplama yapmıyoruz.
    public function getGroupedMonthFromRequest(int $year)
    {
        $db = db_connect();
        $Content = $db->table('contents');
        $result =  $Content
            ->select(['slug as loc','created_at as lastmod'])
            ->where('YEAR(`created_at`)',$year)
            ->orderBy('MONTH(`created_at`)', 'DESC')
            ->get($this->queryLimitsOrganizer->sitemapLimit)
            ->getResultArray();
        $db->close();
        if (empty($result)) {
            throw PageNotFoundException::forPageNotFound();
        }
        $XMLOutput = $this->XMLGenerator(false);
        $this->XMLLooper($result, $XMLOutput,'',true);
        return $XMLOutput->asXML();
    }
}