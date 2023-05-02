<?php

namespace TmrwLife\NtakGuru\Validation;

use Illuminate\Validation\Rules\Enum;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\TouristTax;

trait Rules
{
    protected function ruleCheckIn(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
            ...$this->subRuleGuests(),
            ...$this->subRuleResidentialUnits('occupiedResidentialUnit'),
        ];
    }

    protected function ruleCheckOut(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
            ...$this->subRuleGuests(),
            ...$this->subRuleResidentialUnits('abandonedResidentialUnit'),
        ];
    }

    protected function ruleDailyClose(): array
    {
        return [];
    }

    protected function ruleReservation(): array
    {
        return [
            'arrival' => ['required', 'date_format:Y-m-d'],
            'departure' => ['required', 'date_format:Y-m-d'],
            'cancelled' => ['required', 'boolean'],
            'guestCount' => ['required', 'integer', 'min:1'],
            'reservationNumber' => ['required'],
            'marketSegment' => ['required', new Enum(MarketSegment::class)],
            'reservedAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'salesChannel' => ['required', new Enum(SalesChannel::class)],
            'grossAmount' => ['required', 'numeric', 'min:0'],
            'nationality' => ['required', 'string', 'size:2'],
            'bookedResidentialUnits' => ['required', 'array', 'min:1'],
            'bookedResidentialUnits.*.type' => ['required', new Enum(ResidentialUnitType::class)],
            'bookedResidentialUnits.*.capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    protected function ruleRoomChange(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
            ...$this->subRuleGuests(),
            ...$this->subRuleResidentialUnits('occupiedResidentialUnit'),
            ...$this->subRuleResidentialUnits('abandonedResidentialUnit'),
        ];
    }

    private function subRuleGuests(): array
    {
        return [
            'guests' => ['required', 'array', 'min:1'],
            'guests.*.gender' => ['required', new Enum(Gender::class)],
            'guests.*.guestNumber' => ['required'],
            'guests.*.touristTaxStatus' => ['required', new Enum(TouristTax::class)],
            'guests.*.yearOfBirth' => ['required', 'integer', 'min:1900'],
            'guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'guests.*.residencePostCode' => ['required', 'string'],
            'guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],
        ];
    }

    private function subRuleResidentialUnits(string $key): array
    {
        return [
            $key => ['required', 'array'],
            "$key.type" => ['required', new Enum(ResidentialUnitType::class)],
            "$key.building" => ['required'],
            "$key.number" => ['required'],
            "$key.singleBedCount" => ['required', 'min:0'],
            "$key.doubleBedCount" => ['required', 'min:0'],
            "$key.trundleBedCount" => ['required', 'min:0'],
        ];
    }
}
