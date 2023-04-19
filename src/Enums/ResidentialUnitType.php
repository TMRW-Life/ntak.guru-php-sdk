<?php

namespace TmrwLife\NtakGuru\Enums;

use ArchTech\Enums\Values;

enum ResidentialUnitType: string
{
    use Values;

    case APARTMENT = 'apartment';
    case CUSTOM = 'custom';
    case DORMITORY_BED = 'dormitory_bed';
    case ECONOMY = 'economy';
    case HOLIDAY_HOME = 'holiday_home';
    case JUNIOR_SUITE = 'junior_suite';
    case MOBILE_HOME = 'mobile_home';
    case PARCEL = 'parcel';
    case PRIVATE_ROOM_WITH_OWN_BATH = 'private_room_with_own_bath';
    case PRIVATE_ROOM_WITH_SHARED_BATH = 'private_room_with_shared_bath';
    case STANDARD = 'standard';
    case SUITE = 'suite';
    case SUPERIOR = 'superior';
    case TENT_PLACE_CAMPING_PLACE = 'tent_place_camping_place';
    case OTHER = 'other';

    public function translate(): string
    {
        return match ($this) {
            self::APARTMENT => 'APARTMAN',
            self::CUSTOM => 'EGYEDI',
            self::DORMITORY_BED => 'HALOTERMI_AGY',
            self::ECONOMY => 'ECONOMY',
            self::HOLIDAY_HOME => 'UDULOHAZ',
            self::JUNIOR_SUITE => 'JUNIOR_SUITE',
            self::MOBILE_HOME => 'MOBILHAZ',
            self::PARCEL => 'PARCELLA',
            self::PRIVATE_ROOM_WITH_OWN_BATH => 'PRIVAT_SZOBA_SAJAT_FURDOVEL',
            self::PRIVATE_ROOM_WITH_SHARED_BATH => 'PRIVAT_SZOBA_KOZOS_FURDOVEL',
            self::STANDARD => 'STANDARD',
            self::SUITE => 'SUITE',
            self::SUPERIOR => 'SUPERIOR',
            self::TENT_PLACE_CAMPING_PLACE => 'SATORHELY_KEMPINGHELY',
            self::OTHER => 'EGYEB',
        };
    }
}
