<?php

namespace TmrwLife\NtakGuru;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use TmrwLife\NtakGuru\Entities\Ntak\CheckIn as NtakCheckIn;
use TmrwLife\NtakGuru\Entities\Ntak\CheckOut as NtakCheckOut;
use TmrwLife\NtakGuru\Entities\Ntak\DailyClose as NtakDailyClose;
use TmrwLife\NtakGuru\Entities\Ntak\Reservation as NtakReservation;
use TmrwLife\NtakGuru\Entities\Ntak\RoomChange as NtakRoomChange;
use TmrwLife\NtakGuru\Entities\Viza\CheckIn as VizaCheckIn;
use TmrwLife\NtakGuru\Entities\Viza\CheckOut as VizaCheckOut;
use TmrwLife\NtakGuru\Enums\ChargeItemCategory;
use TmrwLife\NtakGuru\Enums\DocumentType;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\PaymentOption;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Validation\Rules\PaymentOptionSubtypeRule;

abstract class Context implements Arrayable
{
    protected array|null $errors = null;
    protected Factory $validator;

    public function __construct()
    {
        $this->validator = new Factory(trans());
    }

    public function getValidationErrors(): array|null
    {
        return $this->errors;
    }

    public function validate(): bool
    {
        $rules = $this->getRules();

        $validator = $this->validator->make($this->toArray(), $rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->toArray();

            return false;
        }

        return true;
    }

    private function getRules(): array
    {
        return match ($this::class) {
            NtakCheckIn::class => $this->ntakRuleCheckIn(),
            NtakCheckOut::class => $this->ntakRuleCheckOut(),
            NtakDailyClose::class => $this->ntakRuleDailyClose(),
            NtakReservation::class => $this->ntakRuleReservation(),
            NtakRoomChange::class => $this->ntakRuleRoomChange(),
            VizaCheckIn::class => $this->vizaRuleCheckIn(),
            VizaCheckOut::class => $this->vizaRuleCheckOut(),
        };
    }

    private function ntakRuleCheckIn(): array
    {
        return [
            'guests' => ['required', 'array', 'min:1'], 'guests.*.gender' => ['required', Rule::enum(Gender::class)],
            'guests.*.guestNumber' => ['required'],
            'guests.*.touristTaxStatus' => ['required', Rule::enum(TouristTax::class)],
            'guests.*.yearOfBirth' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'guests.*.residencePostCode' => ['required'],
            'guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],

            'occupiedResidentialUnit' => ['required', 'array'],
            'occupiedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'occupiedResidentialUnit.building' => ['required'], 'occupiedResidentialUnit.number' => ['required'],
            'occupiedResidentialUnit.trundleBedCount' => ['required', 'integer', 'min:0'],
            'occupiedResidentialUnit.singleBedCount' => ['required', 'integer', 'min:0'],
            'occupiedResidentialUnit.doubleBedCount' => ['required', 'integer', 'min:0'],

            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'], 'reservationNumber' => ['required'],
        ];
    }

    private function ntakRuleCheckOut(): array
    {
        return [
            'abandonedResidentialUnit' => ['required', 'array'],
            'abandonedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'abandonedResidentialUnit.building' => ['required'], 'abandonedResidentialUnit.number' => ['required'],
            'abandonedResidentialUnit.trundleBedCount' => ['required', 'integer', 'min:0'],
            'abandonedResidentialUnit.singleBedCount' => ['required', 'integer', 'min:0'],
            'abandonedResidentialUnit.doubleBedCount' => ['required', 'integer', 'min:0'],

            'guests' => ['required', 'array', 'min:1'], 'guests.*.gender' => ['required', Rule::enum(Gender::class)],
            'guests.*.guestNumber' => ['required'],
            'guests.*.touristTaxStatus' => ['required', Rule::enum(TouristTax::class)],
            'guests.*.yearOfBirth' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'guests.*.residencePostCode' => ['required'],
            'guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],

            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'], 'reservationNumber' => ['required'],
        ];
    }

    private function ntakRuleDailyClose(): array
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

            'otherLoads' => ['nullable', 'array', 'min:1'], 'otherLoads.*.amount' => ['required', 'numeric', 'min:0'],
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

            'residentialUnits' => ['required', 'array'], 'residentialUnits.all' => ['required', 'integer', 'min:0'],
            'residentialUnits.available' => ['required', 'integer', 'min:0'],
            'residentialUnits.occupied' => ['required', 'integer', 'min:0'],
            'residentialUnits.ooo' => ['required', 'integer', 'min:0'],
            'residentialUnits.oos' => ['required', 'integer', 'min:0'],
        ];
    }

    private function ntakRuleReservation(): array
    {
        return [
            'arrival' => ['required', 'date_format:Y-m-d'], 'bookedResidentialUnits' => ['required', 'array', 'min:1'],
            'bookedResidentialUnits.*.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'bookedResidentialUnits.*.capacity' => ['required', 'integer', 'min:1'],
            'cancelled' => ['required', 'boolean'], 'departure' => ['required', 'date_format:Y-m-d'],
            'grossAmount' => ['required', 'numeric', 'min:0'], 'guestCount' => ['required', 'integer', 'min:1'],
            'marketSegment' => ['required', Rule::enum(MarketSegment::class)],
            'nationality' => ['required', 'string', 'size:2'], 'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'reservationNumber' => ['required'], 'reservedAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'salesChannel' => ['required', Rule::enum(SalesChannel::class)],
        ];
    }

    private function ntakRuleRoomChange(): array
    {
        return [
            'abandonedResidentialUnit' => ['required', 'array'],
            'abandonedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'abandonedResidentialUnit.building' => ['required'], 'abandonedResidentialUnit.number' => ['required'],
            'abandonedResidentialUnit.trundleBedCount' => ['required', 'integer', 'min:0'],
            'abandonedResidentialUnit.singleBedCount' => ['required', 'integer', 'min:0'],
            'abandonedResidentialUnit.doubleBedCount' => ['required', 'integer', 'min:0'],

            'guests' => ['required', 'array', 'min:1'], 'guests.*.gender' => ['required', Rule::enum(Gender::class)],
            'guests.*.guestNumber' => ['required'],
            'guests.*.touristTaxStatus' => ['required', Rule::enum(TouristTax::class)],
            'guests.*.yearOfBirth' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'guests.*.residenceCountryCode' => ['required', 'string', 'size:2'],
            'guests.*.residencePostCode' => ['required'],
            'guests.*.nationalityCountryCode' => ['required', 'string', 'size:2'],

            'occupiedResidentialUnit' => ['required', 'array'],
            'occupiedResidentialUnit.type' => ['required', Rule::enum(ResidentialUnitType::class)],
            'occupiedResidentialUnit.building' => ['required'], 'occupiedResidentialUnit.number' => ['required'],
            'occupiedResidentialUnit.trundleBedCount' => ['required', 'integer', 'min:0'],
            'occupiedResidentialUnit.singleBedCount' => ['required', 'integer', 'min:0'],
            'occupiedResidentialUnit.doubleBedCount' => ['required', 'integer', 'min:0'],

            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'], 'reservationNumber' => ['required'],
        ];
    }

    private function vizaRuleCheckIn(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'], 'guests' => ['required', 'array', 'min:1'],
            'guests.*.id' => ['required', 'uuid'], 'guests.*.arrival' => ['required', 'date_format:Y-m-d H:i:s'],
            'guests.*.departure' => ['required', 'date_format:Y-m-d'],

            'guests.*.manual' => ['required', 'array'], 'guests.*.manual.firstName' => ['required', 'string'],
            'guests.*.manual.lastName' => ['required', 'string'],
            'guests.*.manual.birthFirstName' => ['nullable', 'string'],
            'guests.*.manual.birthLastName' => ['nullable', 'string'],
            'guests.*.manual.dateOfBirth' => ['nullable', 'date_format:Y-m-d'],
            'guests.*.manual.placeOfBirth' => ['nullable', 'string'],
            'guests.*.manual.motherFirstName' => ['nullable', 'string'],
            'guests.*.manual.motherLastName' => ['nullable', 'string'],
            'guests.*.manual.nationality' => ['nullable', 'string', 'size:2'],
            'guests.*.manual.gender' => ['nullable', Rule::enum(Gender::class)],
            'guests.*.manual.documentType' => ['required', Rule::enum(DocumentType::class)],
            'guests.*.manual.documentNumber' => ['required', 'string'],

            'guests.*.scanned' => ['required', 'array'], 'guests.*.scanned.firstName' => ['required', 'string'],
            'guests.*.scanned.lastName' => ['required', 'string'],
            'guests.*.scanned.birthFirstName' => ['nullable', 'string'],
            'guests.*.scanned.birthLastName' => ['nullable', 'string'],
            'guests.*.scanned.dateOfBirth' => ['nullable', 'date_format:Y-m-d'],
            'guests.*.scanned.placeOfBirth' => ['nullable', 'string'],
            'guests.*.scanned.motherFirstName' => ['nullable', 'string'],
            'guests.*.scanned.motherLastName' => ['nullable', 'string'],
            'guests.*.scanned.nationality' => ['nullable', 'string', 'size:2'],
            'guests.*.scanned.gender' => ['nullable', Rule::enum(Gender::class)],
            'guests.*.scanned.documentType' => ['required', Rule::enum(DocumentType::class)],
            'guests.*.scanned.documentNumber' => ['required', 'string'],

            'guests.*.visaNumber' => ['nullable', 'string'],
            'guests.*.visaDateOfEntry' => ['nullable', 'date_format:Y-m-d'],
            'guests.*.visaPlaceOfEntry' => ['nullable', 'string'],
        ];
    }

    private function vizaRuleCheckOut(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'], 'guests' => ['required', 'array', 'min:1'],
            'guests.*.id' => ['required', 'uuid'], 'guests.*.departure' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
