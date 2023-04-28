<?php

namespace Cursotopia\Helpers;

use DateTime;

class Validate {
    public static function date($date): bool {
        if (!is_string($date)) {
            return false;
        }
        $formatDate = DateTime::createFromFormat("Y-m-d", $date);
        return $formatDate && $formatDate->format("Y-m-d") === $date;
    }

    public static function uint($number): bool {
        if (is_array($number) || is_object($number)) {
            return false;
        }

        if (!((is_int($number) || ctype_digit(strval($number))) && intval($number) > 0)) {
            return false;
        }
        return true;
    }
}
