<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class CheckOut implements Arrayable
{
    protected ResidentialUnit $abandonedResidentialUnit;

    protected array $guests;

    protected string $occurredAt;

    protected int|string $reservationNumber;

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
            'guests' => array_map(static fn (Guest $guest) => $guest->toArray(), $this->guests),
            'abandonedResidentialUnit' => $this->abandonedResidentialUnit->toArray(),
        ];
    }
}
