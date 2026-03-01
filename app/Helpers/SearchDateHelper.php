<?php

namespace App\Helpers;

use Carbon\Carbon;

class SearchDateHelper
{
    public static function detectDate($keyword)
    {
        try {
            // 2025-11-12
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $keyword)) {
                return ['date', Carbon::parse($keyword)->toDateString()];
            }

            // 12/11/2025 atau 12-11-2025
            if (preg_match('/^\d{2}[-\/]\d{2}[-\/]\d{4}$/', $keyword)) {
                $date = Carbon::createFromFormat('d-m-Y', str_replace('/', '-', $keyword));
                return ['date', $date->toDateString()];
            }

            // 12 November 2025
            if (preg_match('/^\d{1,2}\s+[A-Za-z]+\s+\d{4}$/', $keyword)) {
                return ['date', Carbon::parse($keyword)->toDateString()];
            }

            // November (bulan saja)
            if (preg_match('/^[A-Za-z]+$/', $keyword)) {
                return ['month', Carbon::parse("1 {$keyword}")->month];
            }

            // November 2025
            if (preg_match('/^[A-Za-z]+\s+\d{4}$/', $keyword)) {
                $d = Carbon::parse("1 {$keyword}");
                return ['month_year', ['month' => $d->month, 'year' => $d->year]];
            }

            // 2025 (tahun saja)
            if (preg_match('/^\d{4}$/', $keyword)) {
                return ['year', $keyword];
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }
}
