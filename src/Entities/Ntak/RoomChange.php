<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use TmrwLife\NtakGuru\Context;

class RoomChange extends Context
{
    protected ?ResidentialUnit $abandonedResidentialUnit = null;

    protected ?array $guests = null;

    protected ?ResidentialUnit $occupiedResidentialUnit = null;

    protected ?string $occurredAt = null;

    protected int|string|null $reservationNumber = null;

    public function addGuest(Guest $guest): RoomChange
    {
        $this->guests[] = $guest;

        return $this;
    }

    public function setAbandonedResidentialUnit(ResidentialUnit $abandonedResidentialUnit): RoomChange
    {
        $this->abandonedResidentialUnit = $abandonedResidentialUnit;

        return $this;
    }

    public function setOccupiedResidentialUnit(ResidentialUnit $occupiedResidentialUnit): RoomChange
    {
        $this->occupiedResidentialUnit = $occupiedResidentialUnit;

        return $this;
    }

    public function setOccurredAt(string $occurredAt): RoomChange
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function setReservationNumber(int|string $reservationNumber): RoomChange
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
            'occupiedResidentialUnit' => $this->occupiedResidentialUnit?->toArray(),
        ];
    }
}
