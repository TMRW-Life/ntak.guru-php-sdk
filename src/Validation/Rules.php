<?php

namespace TmrwLife\NtakGuru\Validation;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use TmrwLife\NtakGuru\Enums\ChargeItemCategory;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\PaymentOption;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Validation\Rules\PaymentOptionSubtypeRule;

trait Rules
{
    protected function ruleCheckIn(): array
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

            'occupiedResidentialUnit' => ['required', 'array'],
            'occupiedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'occupiedResidentialUnit.building' => ['required'],
            'occupiedResidentialUnit.number' => ['required'],
            'occupiedResidentialUnit.singleBedCount' => ['required', 'min:0'],
            'occupiedResidentialUnit.doubleBedCount' => ['required', 'min:0'],
            'occupiedResidentialUnit.trundleBedCount' => ['required', 'min:0'],

            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
        ];
    }

    protected function ruleCheckOut(): array
    {
        return [
            'abandonedResidentialUnit' => ['required', 'array'],
            'abandonedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'abandonedResidentialUnit.building' => ['required'],
            'abandonedResidentialUnit.number' => ['required'],
            'abandonedResidentialUnit.singleBedCount' => ['required', 'min:0'],
            'abandonedResidentialUnit.doubleBedCount' => ['required', 'min:0'],
            'abandonedResidentialUnit.trundleBedCount' => ['required', 'min:0'],

            'guests' => ['required', 'array', 'min:1'],
            'guests.*.gender' => ['required', new Enum(Gender::class)],
            'guests.*.guestNumber' => ['required'],
            'guests.*.touristTaxStatus' => ['required', new Enum(TouristTax::class)],
            'guests.*.yearOfBirth' => ['required', 'integer', 'min:1900'],
            'guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'guests.*.residencePostCode' => ['required', 'string'],
            'guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],

            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
        ];
    }

    protected function ruleDailyClose(): array
    {
        return [
            'afterStayExpenses' => ['nullable', 'array', 'min:1'],
            'afterStayExpenses.*.amount' => ['required', 'numeric', 'min:0'],
            'afterStayExpenses.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'afterStayExpenses.*.paymentOption' => ['required', Rule::enum(PaymentOption::class)],
            'afterStayExpenses.*.paymentOptionSubtype' => [new PaymentOptionSubtypeRule(), 'string'],

            'afterStayLoads' => ['nullable', 'array', 'min:1'],
            'afterStayLoads.*.amount' => ['required', 'numeric', 'min:0'],
            'afterStayLoads.*.category' => ['required', Rule::enum(ChargeItemCategory::class)],
            'afterStayLoads.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'afterStayLoads.*.isTouristTax' => ['required', 'boolean'],
            'afterStayLoads.*.taxPercentage' => ['required', 'integer', 'min:0'],

            'checkOutDaySales' => ['nullable', 'array'],
            'checkOutDaySales.*.expenses' => ['nullable', 'array', 'min:1'],
            'checkOutDaySales.*.expenses.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'checkOutDaySales.*.expenses.*.amount' => ['required', 'numeric', 'min:0'],
            'checkOutDaySales.*.expenses.*.paymentOption' => ['required', Rule::enum(PaymentOption::class)],
            'checkOutDaySales.*.expenses.*.paymentOptionSubtype' => [new PaymentOptionSubtypeRule(), 'string'],
            'checkOutDaySales.*.loads' => ['nullable', 'array', 'min:1'],
            'checkOutDaySales.*.loads.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'checkOutDaySales.*.loads.*.amount' => ['required', 'numeric', 'min:0'],
            'checkOutDaySales.*.loads.*.category' => ['required', Rule::enum(ChargeItemCategory::class)],
            'checkOutDaySales.*.loads.*.isTouristTax' => ['required', 'boolean'],
            'checkOutDaySales.*.loads.*.taxPercentage' => ['required', 'integer', 'min:0'],
            'checkOutDaySales.*.marketSegment' => ['required', Rule::enum(MarketSegment::class)],
            'checkOutDaySales.*.reservationNumber' => ['required'],
            'checkOutDaySales.*.residentialUnit' => ['required', 'array'],
            'checkOutDaySales.*.residentialUnit.building' => ['required'],
            'checkOutDaySales.*.residentialUnit.doubleBedCount' => ['required', 'min:0'],
            'checkOutDaySales.*.residentialUnit.number' => ['required'],
            'checkOutDaySales.*.residentialUnit.singleBedCount' => ['required', 'min:0'],
            'checkOutDaySales.*.residentialUnit.trundleBedCount' => ['required', 'min:0'],
            'checkOutDaySales.*.residentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'checkOutDaySales.*.salesChannel' => ['required', Rule::enum(SalesChannel::class)],

            'closedDay' => ['required', 'date_format:Y-m-d'],

            'otherExpenses' => ['nullable', 'array', 'min:1'],
            'otherExpenses.*.amount' => ['required', 'numeric', 'min:0'],
            'otherExpenses.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'otherExpenses.*.paymentOption' => ['required', Rule::enum(PaymentOption::class)],
            'otherExpenses.*.paymentOptionSubtype' => [new PaymentOptionSubtypeRule(), 'string'],

            'otherLoads' => ['nullable', 'array', 'min:1'],
            'otherLoads.*.amount' => ['required', 'numeric', 'min:0'],
            'otherLoads.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'otherLoads.*.category' => ['required', Rule::enum(ChargeItemCategory::class)],
            'otherLoads.*.taxPercentage' => ['required', 'integer', 'min:0'],

            'outOfServiceResidentialUnits' => ['nullable', 'array'],
            'outOfServiceResidentialUnits.*.building' => ['required'],
            'outOfServiceResidentialUnits.*.doubleBedCount' => ['required', 'min:0'],
            'outOfServiceResidentialUnits.*.number' => ['required'],
            'outOfServiceResidentialUnits.*.singleBedCount' => ['required', 'min:0'],
            'outOfServiceResidentialUnits.*.trundleBedCount' => ['required', 'min:0'],
            'outOfServiceResidentialUnits.*.type' => ['required', Rule::enum(ResidentialUnitType::class)],

            'residentialUnitNights' => ['nullable', 'array'],
            'residentialUnitNights.*.dayUse' => ['required', 'boolean'],
            'residentialUnitNights.*.expenses' => ['nullable', 'array', 'min:1'],
            'residentialUnitNights.*.expenses.*.amount' => ['required', 'numeric', 'min:0'],
            'residentialUnitNights.*.expenses.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'residentialUnitNights.*.expenses.*.paymentOption' => ['required', Rule::enum(PaymentOption::class)],
            'residentialUnitNights.*.expenses.*.paymentOptionSubtype' => [new PaymentOptionSubtypeRule(), 'string'],
            'residentialUnitNights.*.guests.*.gender' => ['required', new Enum(Gender::class)],
            'residentialUnitNights.*.guests' => ['required', 'array', 'min:1'],
            'residentialUnitNights.*.guests.*.guestNumber' => ['required'],
            'residentialUnitNights.*.guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],
            'residentialUnitNights.*.guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'residentialUnitNights.*.guests.*.residencePostCode' => ['required', 'string'],
            'residentialUnitNights.*.guests.*.touristTaxStatus' => ['required', new Enum(TouristTax::class)],
            'residentialUnitNights.*.guests.*.yearOfBirth' => ['required', 'integer', 'min:1900'],
            'residentialUnitNights.*.loads' => ['nullable', 'array', 'min:1'],
            'residentialUnitNights.*.loads.*.amount' => ['required', 'numeric', 'min:0'],
            'residentialUnitNights.*.loads.*.category' => ['required', Rule::enum(ChargeItemCategory::class)],
            'residentialUnitNights.*.loads.*.date' => ['required', 'date_format:Y-m-d H:i:s'],
            'residentialUnitNights.*.loads.*.isTouristTax' => ['required', 'boolean'],
            'residentialUnitNights.*.loads.*.taxPercentage' => ['required', 'integer', 'min:0'],
            'residentialUnitNights.*.marketSegment' => ['required', Rule::enum(MarketSegment::class)],
            'residentialUnitNights.*.reservationNumber' => ['required'],
            'residentialUnitNights.*.residentialUnit' => ['required', 'array'],
            'residentialUnitNights.*.residentialUnit.building' => ['required'],
            'residentialUnitNights.*.residentialUnit.doubleBedCount' => ['required', 'min:0'],
            'residentialUnitNights.*.residentialUnit.number' => ['required'],
            'residentialUnitNights.*.residentialUnit.singleBedCount' => ['required', 'min:0'],
            'residentialUnitNights.*.residentialUnit.trundleBedCount' => ['required', 'min:0'],
            'residentialUnitNights.*.residentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'residentialUnitNights.*.salesChannel' => ['required', Rule::enum(SalesChannel::class)],

            'residentialUnits' => ['required', 'array'],
            'residentialUnits.all' => ['required', 'integer', 'min:0'],
            'residentialUnits.available' => ['required', 'integer', 'min:0'],
            'residentialUnits.occupied' => ['required', 'integer', 'min:0'],
            'residentialUnits.ooo' => ['required', 'integer', 'min:0'],
            'residentialUnits.oos' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function ruleReservation(): array
    {
        return [
            'arrival' => ['required', 'date_format:Y-m-d'],
            'bookedResidentialUnits' => ['required', 'array', 'min:1'],
            'bookedResidentialUnits.*.type' => ['required', new Enum(ResidentialUnitType::class)],
            'bookedResidentialUnits.*.capacity' => ['required', 'integer', 'min:1'],
            'cancelled' => ['required', 'boolean'],
            'departure' => ['required', 'date_format:Y-m-d'],
            'grossAmount' => ['required', 'numeric', 'min:0'],
            'guestCount' => ['required', 'integer', 'min:1'],
            'marketSegment' => ['required', new Enum(MarketSegment::class)],
            'nationality' => ['required', 'string', 'size:2'],
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
            'reservedAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'salesChannel' => ['required', new Enum(SalesChannel::class)],
        ];
    }

    protected function ruleRoomChange(): array
    {
        return [
            'abandonedResidentialUnit' => ['required', 'array'],
            'abandonedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'abandonedResidentialUnit.building' => ['required'],
            'abandonedResidentialUnit.number' => ['required'],
            'abandonedResidentialUnit.singleBedCount' => ['required', 'min:0'],
            'abandonedResidentialUnit.doubleBedCount' => ['required', 'min:0'],
            'abandonedResidentialUnit.trundleBedCount' => ['required', 'min:0'],

            'guests' => ['required', 'array', 'min:1'],
            'guests.*.gender' => ['required', new Enum(Gender::class)],
            'guests.*.guestNumber' => ['required'],
            'guests.*.touristTaxStatus' => ['required', new Enum(TouristTax::class)],
            'guests.*.yearOfBirth' => ['required', 'integer', 'min:1900'],
            'guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'guests.*.residencePostCode' => ['required', 'string'],
            'guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],

            'occupiedResidentialUnit' => ['required', 'array'],
            'occupiedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'occupiedResidentialUnit.building' => ['required'],
            'occupiedResidentialUnit.number' => ['required'],
            'occupiedResidentialUnit.singleBedCount' => ['required', 'min:0'],
            'occupiedResidentialUnit.doubleBedCount' => ['required', 'min:0'],
            'occupiedResidentialUnit.trundleBedCount' => ['required', 'min:0'],

            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'],
        ];
    }
}
