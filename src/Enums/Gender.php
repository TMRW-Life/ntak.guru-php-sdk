<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum Gender: string
{
    use Values;

    case MALE = 'male';
    case FEMALE = 'female';
    case UNKNOWN = 'unknown';

    public function translate(): string
    {
        return match ($this) {
            self::MALE => 'FERFI',
            self::FEMALE => 'NO',
            self::UNKNOWN => 'EGYEB_VAGY_NEM_ISMERT',
        };
    }
}
