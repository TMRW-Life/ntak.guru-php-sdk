<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum ChargeItemCategory: string
{
    use Values;

    case FEE = 'fee';
    case TOURIST_TAX = 'tourist_tax';
    case FOOD = 'food';
    case DRINK = 'drink';
    case WELLNESS = 'wellness';
    case OTHER = 'other';

    public function translate(): string
    {
        return match ($this) {
            self::FEE => 'SZALLASDIJ',
            self::TOURIST_TAX => 'IFA',
            self::FOOD => 'ETEL',
            self::DRINK => 'ITAL',
            self::WELLNESS => 'GYOGY_ES_WELLNESS',
            self::OTHER => 'EGYEB',
        };
    }
}
