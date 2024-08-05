<?php

declare(strict_types = 1);

use Illuminate\Support\Number;

if (!function_exists('currency')) {
    function currency($value, ?string $language = null): string | false
    {
        $language = match (app()->getLocale()) {
            'en'    => 'USD',
            default => $language ?: 'BRL',
        };

        return Number::currency($value, in: $language);
    }
}
