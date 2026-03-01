<?php

namespace App\Helpers;

class PhoneHelper
{
    public static function normalize(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '08')) {
            return '628' . substr($phone, 2);
        }

        if (str_starts_with($phone, '62')) {
            return $phone;
        }

        return null;
    }
}
