<?php

namespace App\Validation;

class Escape
{

    public function escUserInput(string $str, string $fields, array $data)
    {

        if ($str != strip_tags($str)) {
            return false;
        }
    }
}