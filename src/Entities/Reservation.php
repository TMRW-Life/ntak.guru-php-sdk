<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType as ResidentialUnitEnum;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Reservation implements Arrayable
{
    protected string $arrival;

    protected array $bookedResidentialUnits;

    protected bool $cancelled;

    protected string $departure;

    protected float $grossAmount;

    protected int $guestCount;

    protected MarketSegment $marketSegment;

    protected string $nationality;

    protected string $occurredAt;

    protected int|string $reservationNumber;

    protected string $reservedAt;

    protected SalesChannel $salesChannel;

    public function setArrival(string $arrival): Reservation
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function addBookedResidentialUnits(ResidentialUnitEnum $type, int $capacity): Reservation
    {
        $this->bookedResidentialUnits[] = [
            'type' => $type->value,
            'capacity' => $capacity,
        ];

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
            'salesChannel' => $this->salesChannel->value,
            'marketSegment' => $this->marketSegment->value,
            'grossAmount' => $this->grossAmount,
            'guestCount' => $this->guestCount,
            'bookedResidentialUnits' => $this->bookedResidentialUnits,
        ];
    }
}
