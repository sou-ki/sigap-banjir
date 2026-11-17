<?php

namespace App\Support;

class IndonesianPhoneNumber
{
    public static function normalize(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if (str_starts_with($digits, '62')) {
            return '0'.substr($digits, 2);
        }

        return str_starts_with($digits, '0') ? $digits : '0'.$digits;
    }
}
