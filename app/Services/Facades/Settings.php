<?php

declare(strict_types = 1);

namespace App\Services\Facades;

use App\Models\Setting;
use App\Services\SettingService;

/**
 * @method static string|null get(string $key, mixed $default = null)
 * @method static Setting set(string $key, mixed $value, string $type = 'string')
 * @method static void forgot(string $key)
 * @see SettingsService
 */
class Settings
{
    protected static function getFacadeAccessor(): string
    {
        return SettingService::class;
    }
}
