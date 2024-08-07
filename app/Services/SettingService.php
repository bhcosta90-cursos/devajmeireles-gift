<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Setting;
use Closure;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function get(string $key, mixed $default = null): ?string
    {
        $default = $default instanceof Closure ? $default() : $default;
        $key     = strtoupper($key);

        $get = Cache::rememberForever(
            "settings::{$key}",
            fn () => Setting::firstWhere('key', '=', $key)?->value ?? $default
        );

        return $get ? $this->parse($get) : null;
    }

    public function set(string $key, mixed $value, string $type = 'string'): Setting
    {
        $this->forgot($key);

        return Setting::updateOrCreate([
            'key' => strtoupper($key),
        ], [
            'value' => $type === 'boolean' ? (bool) $value : $value,
            'type'  => $type,
        ]);
    }

    public function forgot(string $key): void
    {
        Cache::forget("settings::{$key}");
    }

    private function parse(string $result): string
    {
        if (!str($result)->contains('%')) {
            return $result;
        }

        preg_match_all('/\{%(.*?)%\}/', $result, $matches);

        if (empty($matches[1])) {
            return $result;
        }

        foreach ($matches[1] as $match) {
            $value = $this->get($match);

            if ($match === 'data') {
                $value = rescue(fn () => now()->parse($value)->format('d/m/Y'), report: false);
            }

            $result = str_replace(
                "{%{$match}%}",
                $value,
                $result
            );
        }

        return $result;
    }
}
