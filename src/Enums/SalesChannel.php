<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum SalesChannel: string
{
    use Values;

    case DIRECTLY_ONLINE = 'directly_online';
    case DIRECTLY_TRADITIONAL = 'directly_traditional';
    case INTERMEDIARY_ONLINE = 'intermediary_online';
    case INTERMEDIARY_TRADITIONAL = 'intermediary_traditional';

    public function translate(): string
    {
        return match ($this) {
            self::DIRECTLY_ONLINE => 'DIREKT_ONLINE',
            self::DIRECTLY_TRADITIONAL => 'DIREKT_HAGYOMANYOS',
            self::INTERMEDIARY_ONLINE => 'KOZVETITO_ONLINE',
            self::INTERMEDIARY_TRADITIONAL => 'KOZVETITO_HAGYOMANYOS',
        };
    }
}
