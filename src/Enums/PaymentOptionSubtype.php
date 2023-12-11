<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum PaymentOptionSubtype: string
{
    use Values;

    case HOSPITALITY = 'hospitality';
    case LEISURE = 'leisure';
    case ACCOMMODATION = 'accommodation';

    public function translate(): string
    {
        return match ($this) {
            self::HOSPITALITY => 'VENDEGLATAS',
            self::LEISURE => 'SZABADIDO',
            self::ACCOMMODATION => 'SZALLASHELY',
        };
    }
}
