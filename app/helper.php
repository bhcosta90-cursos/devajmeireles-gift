<?php

declare(strict_types = 1);

use Illuminate\Support\Number;

if (!function_exists('currency')) {
    function currency($value): string | false
    {
        return Number::currency($value, in: 'BRL');
    }
}
