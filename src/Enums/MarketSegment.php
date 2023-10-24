<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum MarketSegment: string
{
    use Values;

    case LEISURE_PERSONAL = 'leisure_personal';
    case LEISURE_GROUP = 'leisure_group';
    case BUSINESS_PERSONAL = 'business_personal';
    case BUSINESS_GROUP = 'business_group';
    case UNKNOWN = 'unknown';

    public function translate(): string
    {
        return match ($this) {
            self::LEISURE_PERSONAL => 'SZABADIDOS_EGYENI',
            self::LEISURE_GROUP => 'SZABADIDOS_CSOPORTOS',
            self::BUSINESS_PERSONAL => 'UZLETI_EGYENI',
            self::BUSINESS_GROUP => 'UZLETI_CSOPORTOS',
            self::UNKNOWN => 'ISMERETLEN',
        };
    }
}
