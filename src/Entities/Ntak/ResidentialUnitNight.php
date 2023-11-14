<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class ResidentialUnitNight implements Arrayable
{
    protected bool $dayUse = false;
    protected array $expenses = [];
    protected array $guests;
    protected array $loads = [];
    protected MarketSegment $marketSegment;
    protected int|string $reservationNumber;
    protected ResidentialUnit $residentialUnit;
    protected SalesChannel $salesChannel;

    public function addExpense(Expense $expense): ResidentialUnitNight
    {
        $this->expenses[] = $expense;

        return $this;
    }

    public function addGuest(Guest $guest): ResidentialUnitNight
    {
        $this->guests[] = $guest;

        return $this;
    }

    public function addLoad(Load $load): ResidentialUnitNight
    {
        $this->loads[] = $load;

        return $this;
    }

    public function setDayUse(bool $dayUse): ResidentialUnitNight
    {
        $this->dayUse = $dayUse;

        return $this;
    }

    public function setMarketSegment(MarketSegment $marketSegment): ResidentialUnitNight
    {
        $this->marketSegment = $marketSegment;

        return $this;
    }

    public function setReservationNumber(int|string $reservationNumber): ResidentialUnitNight
    {
        $this->reservationNumber = $reservationNumber;

        return $this;
    }

    public function setResidentialUnit(ResidentialUnit $residentialUnit): ResidentialUnitNight
    {
        $this->residentialUnit = $residentialUnit;

        return $this;
    }

    public function setSalesChannel(SalesChannel $salesChannel): ResidentialUnitNight
    {
        $this->salesChannel = $salesChannel;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'dayUse' => $this->dayUse,
            'expenses' => array_map(static fn (Expense $expense) => $expense->toArray(), $this->expenses),
            'guests' => array_map(static fn (Guest $guest) => $guest->toArray(), $this->guests),
            'loads' => array_map(static fn (Load $load) => $load->toArray(), $this->loads),
            'marketSegment' => $this->marketSegment->value,
            'reservationNumber' => $this->reservationNumber,
            'residentialUnit' => $this->residentialUnit->toArray(),
            'salesChannel' => $this->salesChannel->value,
        ];
    }
}
