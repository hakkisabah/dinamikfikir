<?php


namespace App\Controllers\Requests;


interface Comments
{
    public function setComment();

    public function getComments(int $comment);

//    public function updateComment(string $contentSlug, array $payload);

    public function deleteComment(int $id);
}