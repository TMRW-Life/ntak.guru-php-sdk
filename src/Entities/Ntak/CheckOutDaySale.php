<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use Illuminate\Contracts\Support\Arrayable;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\SalesChannel;

class CheckOutDaySale implements Arrayable
{
    protected array $expenses = [];
    protected array $loads = [];
    protected MarketSegment $marketSegment;
    protected int|string $reservationNumber;
    protected ResidentialUnit $residentialUnit;
    protected SalesChannel $salesChannel;

    public function addExpense(Expense $expense): CheckOutDaySale
    {
        $this->expenses[] = $expense;

        return $this;
    }

    public function addLoad(Load $load): CheckOutDaySale
    {
        $this->loads[] = $load;

        return $this;
    }

    public function setMarketSegment(MarketSegment $marketSegment): CheckOutDaySale
    {
        $this->marketSegment = $marketSegment;

        return $this;
    }

    public function setReservationNumber(int|string $reservationNumber): CheckOutDaySale
    {
        $this->reservationNumber = $reservationNumber;

        return $this;
    }

    public function setResidentialUnit(ResidentialUnit $residentialUnit): CheckOutDaySale
    {
        $this->residentialUnit = $residentialUnit;

        return $this;
    }

    public function setSalesChannel(SalesChannel $salesChannel): CheckOutDaySale
    {
        $this->salesChannel = $salesChannel;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'expenses' => array_map(static fn (Expense $expense) => $expense->toArray(), $this->expenses),
            'loads' => array_map(static fn (Load $load) => $load->toArray(), $this->loads),
            'marketSegment' => $this->marketSegment->value,
            'reservationNumber' => $this->reservationNumber,
            'residentialUnit' => $this->residentialUnit->toArray(),
            'salesChannel' => $this->salesChannel->value,
        ];
    }
}
