<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum ChargeItemCategory: string
{
    use Values;

    case ACCOMMODATION_FEE = 'accommodation_fee';
    case TOURIST_TAX = 'tourist_tax';
    case FOOD = 'food';
    case DRINK = 'drink';
    case HEALTH_AND_WELLNESS = 'health_and_wellness';
    case OTHER = 'other';

    public function translate(): string
    {
        return match ($this) {
            self::ACCOMMODATION_FEE => 'SZALLASDIJ',
            self::TOURIST_TAX => 'IFA',
            self::FOOD => 'ETEL',
            self::DRINK => 'ITAL',
            self::HEALTH_AND_WELLNESS => 'GYOGY_ES_WELLNESS',
            self::OTHER => 'EGYEB',
        };
    }
}
