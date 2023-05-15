<?php

namespace Cursotopia\Helpers;

use DateTime;
use IntlDateFormatter;

class Format {
    public static function decimal($number): string {
        if (is_numeric($number)) {
            $formatNumber = number_format($number, 2, '.', ',');
        }
        else {
            $formatNumber = "0.00";
        }
        return "$formatNumber";
    }

    public static function money($number): string {
        if (is_numeric($number)) {
            $formatNumber = number_format($number, 2, '.', ',');
        }
        else {
            $formatNumber = "0.00";
        }
        return "$$formatNumber MXN";
    }

    public static function date($date): string {
        if (empty($date)) {
            return "N/A";
        }
        
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

    public static function datetime($datetime): string {
        if (empty($datetime)) {
            return "N/A";
        }

        if (strtotime($datetime)) {
            $formatDate = date('d M Y G:i', strtotime($datetime));
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

    public static function hours($number): string {
        if (is_null($number)) {
            return "0 horas";
        }

        if ($number < 1) {
            return "<1 hora";
        } 
        else {
            $horas = floor($number);
            return self::pluralize($horas, "hora");
        }
    }

    public static function sanitize($value): string {
        if (empty($value)) {
            return "";
        }
        if (is_array($value) || is_object($value)) {
            return "";
        }
        return htmlspecialchars($value);
    }
}
