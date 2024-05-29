<?php

namespace App\Utils;

class ArrayOperations
{
    static function findOnArray($string, $array)
    {
        $found = false;

        foreach ($array as $item) {
            if (strpos($item, $string) !== false) {
                $found = true;
                break;
            }
        }
        return $found;
    }
}
