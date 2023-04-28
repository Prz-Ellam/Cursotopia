<?php

namespace Cursotopia\Helpers;

use DateTime;
use IntlDateFormatter;

class Format {
    public static function money($number): string {
        if (is_numeric($number)) {
            $formatNumber = number_format($number, 2, '.', ',');
        }
        else {
            $formatNumber = "0.00";
        }
        return "$ $formatNumber MXN";
    }

    public static function date($date): string {
        if (strtotime($date)) {
            $format = date_create($date);
            $formatDate = date_format($format, "d M Y");
            $format = new IntlDateFormatter('es_ES', IntlDateFormatter::SHORT, IntlDateFormatter::NONE, NULL, NULL, 'dd MMM yyyy');
            $formatDate = $format->format(new DateTime($date));
        }
        else {
            $formatDate = "N/A";
        }
        return $formatDate;
    }

    public static function pluralize(int $count, string $singularWord, ?string $pluralWord = null) {
        if (!$pluralWord) {
            $pluralWord = $singularWord . "s";
        }
        if ($count == 1) {
            return "$count $singularWord";
        } 
        else {
            return "$count $pluralWord";
        }
    }

    public static function hours(float $number): string {
        if ($number < 1) {
            return "<1 horas";
        } 
        else {
            $horas = floor($number);
            return self::pluralize($horas, "hora");
        }
    }

    public static function sanitize($value): string {
        if (is_array($value) || is_object($value)) {
            return "";
        }
        return htmlspecialchars($value);
    }
}
