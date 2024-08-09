<?php

declare(strict_types = 1);

namespace App\Enums;

enum DeliveryType: int
{
    use Traits\Selectable;

    case InPerson = 1;
    case Remotely = 2;

    public function label(): string
    {
        return match ($this) {
            self::InPerson => __('In Person'),
            self::Remotely => __('Remotely'),
        };
    }

    public function tip()
    {
        return match ($this) {
            self::InPerson => __('Indicates that you will attend the event'),
            self::Remotely => __('Delivery will be arranged'),
        };
    }
}
