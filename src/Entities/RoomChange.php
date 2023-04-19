<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Entities\ResidentialUnit as ResidentialUnitAlias;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class RoomChange implements Arrayable
{
    protected ResidentialUnitAlias $abandonedResidentialUnit;

    protected array $guests;

    protected ResidentialUnitAlias $occupiedResidentialUnit;

    protected string $occurredAt;

    protected int|string $reservationNumber;

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
            'guests' => array_map(static fn (Guest $guest) => $guest->toArray(), $this->guests),
            'abandonedResidentialUnit' => $this->abandonedResidentialUnit->toArray(),
            'occupiedResidentialUnit' => $this->occupiedResidentialUnit->toArray(),
        ];
    }
}
