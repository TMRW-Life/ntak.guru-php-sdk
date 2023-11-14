<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use TmrwLife\NtakGuru\Interfaces\Context;

class CheckOut implements Context
{
    protected ?ResidentialUnit $abandonedResidentialUnit = null;

    protected ?array $guests = null;

    protected ?string $occurredAt = null;

    protected int|string|null $reservationNumber = null;

    public function addGuest(Guest $guest): CheckOut
    {
        $this->guests[] = $guest;

        return $this;
    }

    public function setAbandonedResidentialUnit(ResidentialUnit $residentialUnit): CheckOut
    {
        $this->abandonedResidentialUnit = $residentialUnit;

        return $this;
    }

    public function setOccurredAt(string $occurredAt): CheckOut
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function setReservationNumber(int|string $reservationNumber): CheckOut
    {
        $this->reservationNumber = $reservationNumber;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'reservationNumber' => $this->reservationNumber,
            'occurredAt' => $this->occurredAt,
            'guests' => $this->guests ? array_map(static fn (Guest $guest) => $guest->toArray(), $this->guests) : null,
            'abandonedResidentialUnit' => $this->abandonedResidentialUnit?->toArray(),
        ];
    }
}
