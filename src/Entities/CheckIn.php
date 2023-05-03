<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class CheckIn implements Arrayable
{
    protected ?array $guests = null;

    protected ?ResidentialUnit $occupiedResidentialUnit = null;

    protected ?string $occurredAt = null;

    protected int|string|null $reservationNumber = null;

    public function addGuest(Guest $guest): CheckIn
    {
        $this->guests[] = $guest;

        return $this;
    }

    public function setOccupiedResidentialUnit(ResidentialUnit $residentialUnit): CheckIn
    {
        $this->occupiedResidentialUnit = $residentialUnit;

        return $this;
    }

    public function setOccurredAt(string $occurredAt): CheckIn
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function setReservationNumber(int|string $reservationNumber): CheckIn
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
            'occupiedResidentialUnit' => $this->occupiedResidentialUnit?->toArray(),
        ];
    }
}
