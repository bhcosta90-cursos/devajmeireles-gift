<?php

declare(strict_types = 1);

namespace App\Enums;

enum CardType: int
{
    use Traits\Selectable;

    case AllItems      = 1;
    case ItemSigned    = 2;
    case ItemNotSigned = 3;

    public function label(): string
    {
        return match ($this) {
            self::AllItems      => __('All Items'),
            self::ItemSigned    => __('Item Signed'),
            self::ItemNotSigned => __('Item Not Signed'),
        };
    }
}