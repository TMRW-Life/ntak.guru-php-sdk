<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum PaymentOption: string
{
    use Values;

    case CARD = 'card';
    case CASH = 'cash';
    case SZEP = 'szep';
    case TRANSFER = 'transfer';
    case VOUCHER = 'voucher';
    case RETROSPECTIVE = 'retrospective';
    case OTHER = 'other';

    public function translate(): string
    {
        return match ($this) {
            self::CARD => 'BANKKARTYA',
            self::CASH => 'KESZPENZ',
            self::SZEP => 'SZEP_KARTYA',
            self::TRANSFER => 'ATUTALAS',
            self::VOUCHER => 'UTALVANY',
            self::RETROSPECTIVE => 'UTOLAGOS',
            self::OTHER => 'EGYEB',
        };
    }
}
