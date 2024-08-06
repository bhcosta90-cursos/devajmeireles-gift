<?php

declare(strict_types = 1);

namespace App\Services\Facades;

use App\Services\SettingService;

class Settings
{
    protected static function getFacadeAccessor(): string
    {
        return SettingService::class;
    }
}
