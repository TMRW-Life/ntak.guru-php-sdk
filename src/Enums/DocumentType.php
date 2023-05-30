<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum DocumentType: string
{
    use Values;

    case IDENTITY_CARD = 'identity_card';
    case PASSPORT = 'passport';
    case DRIVING_LICENSE = 'driving_license';
    case OTHER = 'other';

    public function translate(): string
    {
        return match ($this) {
            self::IDENTITY_CARD => 'SZEM_IG',
            self::PASSPORT => 'UTLEVEL',
            self::DRIVING_LICENSE => 'VEZ_ENG',
            self::OTHER => 'EGYEB',
        };
    }
}
