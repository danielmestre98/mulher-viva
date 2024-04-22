<?php

namespace App\Utils;

class StringOperations
{
    static function removeSpecialCharacters($string)
    {
        return str_replace(".", "", str_replace("-", "", $string));
    }
}
