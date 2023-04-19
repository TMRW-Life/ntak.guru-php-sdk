<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum TouristTax: string
{
    use Values;

    case OBLIGED = 'obliged';
    case IM1 = 'im1';
    case IM2 = 'im2';
    case IM3 = 'im3';
    case IM4 = 'im4';
    case IM5 = 'im5';
    case IM6 = 'im6';
    case IM7 = 'im7';
    case IM8 = 'im8';
    case IM9 = 'im9';
    case IM10 = 'im10';
    case IM11 = 'im11';

    public function translate(): string
    {
        return match ($this) {
            self::OBLIGED => 'KOTELES',
            self::IM1 => 'IM1',
            self::IM2 => 'IM2',
            self::IM3 => 'IM3',
            self::IM4 => 'IM4',
            self::IM5 => 'IM5',
            self::IM6 => 'IM6',
            self::IM7 => 'IM7',
            self::IM8 => 'IM8',
            self::IM9 => 'IM9',
            self::IM10 => 'IM10',
            self::IM11 => 'IM11',
        };
    }
}
