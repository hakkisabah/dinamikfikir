<?php


namespace App\Validation;


class CommentRules
{
    public function validateComment(string $str, string $fields, array $data)
    {
        $cleanComment = htmlspecialchars(strip_tags($data['comment']));

        // Girilen yorumda xss güvenliği için kontrol yapılıyor..
        if (strlen($data['comment']) != strlen($cleanComment))
            return false;

        return true;
    }

}