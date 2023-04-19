<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum MarketSegment: string
{
    use Values;

    case VACATION_INDIVIDUAL = 'vacation_individual';
    case VACATION_GROUP = 'vacation_group';
    case BUSINESS_INDIVIDUAL = 'business_individual';
    case BUSINESS_GROUP = 'business_group';
    case UNKNOWN = 'unknown';

    public function translate(): string
    {
        return match ($this) {
            self::VACATION_INDIVIDUAL => 'SZABADIDOS_EGYENI',
            self::VACATION_GROUP => 'SZABADIDOS_CSOPORTOS',
            self::BUSINESS_INDIVIDUAL => 'UZLETI_EGYENI',
            self::BUSINESS_GROUP => 'UZLETI_CSOPORTOS',
            self::UNKNOWN => 'ISMERETLEN',
        };
    }
}
