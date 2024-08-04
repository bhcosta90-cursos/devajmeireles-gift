<?php

declare(strict_types = 1);

namespace App\Enums;

enum DeliveryType: int
{
    use Traits\Selectable;

    case InPerson = 1;
    case Remotely = 2;

    public function label($type): string
    {
        return match ($this) {
            self::InPerson => __('In Person'),
            self::Remotely => __('Remotely'),
        };
    }
}
