<?php

declare(strict_types = 1);

namespace App\Enums\Traits;

trait Selectable
{
    public static function toSelect(): array
    {
        return collect(self::cases())
            ->map(fn (self $case) => [
                'value' => $case->value,
                'label' => $case->label($case),
            ])
            ->toArray();
    }

    abstract public function label($type): string;
}
