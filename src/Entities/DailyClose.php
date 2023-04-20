<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class DailyClose implements Arrayable
{
    protected bool $accommodationNotOperating = false;
    protected array $afterStayExpenses = [];
    protected array $afterStayLoads = [];
    protected array $checkOutDaySales = [];
    protected string $closedDay;
    protected array $otherExpenses = [];
    protected array $otherLoads = [];
    protected array $outOfServiceResidentialUnits = [];
    protected array $residentialUnitNights = [];
    protected array $residentialUnits = [
        'all' => 0,
        'ooo' => 0,
        'oos' => 0,
        'occupied' => 0,
        'available' => 0,
    ];

    public function accommodationNotOperating(): DailyClose
    {
        $this->accommodationNotOperating = true;

        return $this;
    }

    public function addAfterStayExpense(Expense $expense): DailyClose
    {
        $this->afterStayExpenses[] = $expense;

        return $this;
    }

    public function addAfterStayLoad(Load $load): DailyClose
    {
        $this->afterStayLoads[] = $load;

        return $this;
    }

    public function addCheckOutDaySale(CheckOutDaySale $checkOutDaySale): DailyClose
    {
        $this->checkOutDaySales[] = $checkOutDaySale;

        return $this;
    }

    public function addOtherExpense(Expense $expense): DailyClose
    {
        $this->otherExpenses[] = $expense;

        return $this;
    }

    public function addOtherLoad(Load $load): DailyClose
    {
        $this->otherLoads[] = $load;

        return $this;
    }

    public function addOutOfServiceResidentialUnit(ResidentialUnit $residentialUnit): DailyClose
    {
        $this->outOfServiceResidentialUnits[] = $residentialUnit;

        return $this;
    }

    public function addResidentialUnitNight(ResidentialUnitNight $residentialUnitNight): DailyClose
    {
        $this->residentialUnitNights[] = $residentialUnitNight;

        return $this;
    }

    public function setClosedDay(string $closedDay): DailyClose
    {
        $this->closedDay = $closedDay;

        return $this;
    }

    public function setResidentialUnits(int $all, int $ooo, int $oos, int $occupied, int $available): DailyClose
    {
        $this->residentialUnits = [
            'all' => $all,
            'ooo' => $ooo,
            'oos' => $oos,
            'occupied' => $occupied,
            'available' => $available,
        ];

        return $this;
    }

    public function toArray(): array
    {
        if ($this->accommodationNotOperating) {
            return [
                'accommodationNotOperating' => true,
                'closedDay' => $this->closedDay,
                'residentialUnits' => $this->residentialUnits,
            ];
        }

        return [
            'afterStayExpenses' => array_map(
                static fn (Expense $expense) => $expense->toArray(),
                $this->afterStayExpenses
            ),
            'afterStayLoads' => array_map(
                static fn (Load $load) => $load->toArray(),
                $this->afterStayLoads
            ),
            'checkOutDaySales' => array_map(
                static fn (CheckOutDaySale $checkOutDaySale) => $checkOutDaySale->toArray(),
                $this->checkOutDaySales
            ),
            'closedDay' => $this->closedDay,
            'otherExpenses' => array_map(
                static fn (Expense $expense) => $expense->toArray(),
                $this->otherExpenses
            ),
            'otherLoads' => array_map(
                static fn (Load $load) => $load->toArray(),
                $this->otherLoads
            ),
            'outOfServiceResidentialUnits' => array_map(
                static fn (ResidentialUnit $residentialUnit) => $residentialUnit->toArray(),
                $this->outOfServiceResidentialUnits
            ),
            'residentialUnitNights' => array_map(
                static fn (ResidentialUnitNight $residentialUnitNight) => $residentialUnitNight->toArray(),
                $this->residentialUnitNights
            ),
            'residentialUnits' => $this->residentialUnits,
        ];
    }
}
