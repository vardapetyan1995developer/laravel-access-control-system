<?php

namespace App\Helpers;

class Input
{
    /**
     * @param string|null $value
     * @return string
     */
    public static function filter(?string $value = null): string
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);

        return $value;
    }
}
