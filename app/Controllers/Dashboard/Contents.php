<?php


namespace App\Controllers\Dashboard;


/**
 * Interface Contents
 * @package App\Controllers\Dashboard
 */
interface Contents
{
    /**
     * @param object $request
     * @return mixed
     */
    public function setContent(object $request);

    /**
     * @param string $where
     * @param $contentSlug
     * @return mixed
     */
    public function getContent(string $where, $contentSlug);

    /**
     * @param object $request
     * @param array $currentContent
     * @return mixed
     */
    public function updateContent(object $request, array $currentContent);

    /**
     * @param string $where
     * @param string $contentSlug
     * @return mixed
     */
    public function deleteContent(string $where, string $contentSlug);

    /**
     * @param string $contentSlug
     * @return mixed
     */
    public function publicContent(string $contentSlug);

    /**
     * @param $text
     * @return mixed
     */
    public function slugify($text);


}