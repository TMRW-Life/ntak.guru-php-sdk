<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType as ResidentialUnitEnum;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Interfaces\Context;

class Reservation implements Context
{
    protected ?string $arrival = null;

    protected array $bookedResidentialUnits = [];

    protected ?bool $cancelled = null;

    protected ?string $departure = null;

    protected ?float $grossAmount = null;

    protected ?int $guestCount = null;

    protected ?MarketSegment $marketSegment = null;

    protected ?string $nationality = null;

    protected ?string $occurredAt = null;

    protected int|string|null $reservationNumber = null;

    protected string $reservedAt = '';

    protected ?SalesChannel $salesChannel = null;

    public function addBookedResidentialUnits(ResidentialUnitEnum $type, int $capacity): Reservation
    {
        $this->bookedResidentialUnits[] = [
            'type' => $type->value,
            'capacity' => $capacity,
        ];

        return $this;
    }

    public function setArrival(string $arrival): Reservation
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function setCancelled(bool $cancelled): Reservation
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    public function setDeparture(string $departure): Reservation
    {
        $this->departure = $departure;

        return $this;
    }

    public function setGrossAmount(float $grossAmount): Reservation
    {
        $this->grossAmount = $grossAmount;

        return $this;
    }

    public function setGuestCount(int $guestCount): Reservation
    {
        $this->guestCount = $guestCount;

        return $this;
    }

    public function setMarketSegment(MarketSegment $marketSegment): Reservation
    {
        $this->marketSegment = $marketSegment;

        return $this;
    }

    public function setNationality(string $nationality): Reservation
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function setOccurredAt(string $occurredAt): Reservation
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function setReservationNumber(int|string $reservationNumber): Reservation
    {
        $this->reservationNumber = $reservationNumber;

        return $this;
    }

    public function setReservedAt(string $reservedAt): Reservation
    {
        $this->reservedAt = $reservedAt;

        return $this;
    }

    public function setSalesChannel(SalesChannel $salesChannel): Reservation
    {
        $this->salesChannel = $salesChannel;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'reservationNumber' => $this->reservationNumber,
            'occurredAt' => $this->occurredAt,
            'reservedAt' => $this->reservedAt,
            'cancelled' => $this->cancelled,
            'nationality' => $this->nationality,
            'arrival' => $this->arrival,
            'departure' => $this->departure,
            'salesChannel' => $this->salesChannel?->value,
            'marketSegment' => $this->marketSegment?->value,
            'grossAmount' => $this->grossAmount,
            'guestCount' => $this->guestCount,
            'bookedResidentialUnits' => $this->bookedResidentialUnits,
        ];
    }
}
