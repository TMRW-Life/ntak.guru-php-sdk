<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum SalesChannel: string
{
    use Values;

    case DIRECT_ONLINE = 'direct_online';
    case DIRECT_TRADITIONAL = 'direct_traditional';
    case AGENCY_ONLINE = 'agency_online';
    case AGENCY_TRADITIONAL = 'agency_traditional';

    public function translate(): string
    {
        return match ($this) {
            self::DIRECT_ONLINE => 'DIREKT_ONLINE',
            self::DIRECT_TRADITIONAL => 'DIREKT_HAGYOMANYOS',
            self::AGENCY_ONLINE => 'KOZVETITO_ONLINE',
            self::AGENCY_TRADITIONAL => 'KOZVETITO_HAGYOMANYOS',
        };
    }
}
