<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class DailyClose implements Arrayable
{
    protected bool $accommodationNotOperating = false;
    protected ?array $afterStayExpenses = null;
    protected ?array $afterStayLoads = null;
    protected ?array $checkOutDaySales = null;
    protected ?string $closedDay = null;
    protected ?array $otherExpenses = null;
    protected ?array $otherLoads = null;
    protected ?array $outOfServiceResidentialUnits = null;
    protected ?array $residentialUnitNights = null;
    protected array $residentialUnits = [
        'all' => null,
        'ooo' => null,
        'oos' => null,
        'occupied' => null,
        'available' => null,
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
            'afterStayExpenses' => $this->afterStayExpenses ? array_map(
                static fn (Expense $expense) => $expense->toArray(),
                $this->afterStayExpenses
            ) : null,
            'afterStayLoads' => $this->afterStayLoads ? array_map(
                static fn (Load $load) => $load->toArray(),
                $this->afterStayLoads
            ) : null,
            'checkOutDaySales' => $this->checkOutDaySales ? array_map(
                static fn (CheckOutDaySale $checkOutDaySale) => $checkOutDaySale->toArray(),
                $this->checkOutDaySales
            ) : null,
            'closedDay' => $this->closedDay,
            'otherExpenses' => $this->otherExpenses ? array_map(
                static fn (Expense $expense) => $expense->toArray(),
                $this->otherExpenses
            ) : null,
            'otherLoads' => $this->otherLoads ? array_map(
                static fn (Load $load) => $load->toArray(),
                $this->otherLoads
            ) : null,
            'outOfServiceResidentialUnits' => $this->outOfServiceResidentialUnits ? array_map(
                static fn (ResidentialUnit $residentialUnit) => $residentialUnit->toArray(),
                $this->outOfServiceResidentialUnits
            ) : null,
            'residentialUnitNights' => $this->residentialUnitNights ? array_map(
                static fn (ResidentialUnitNight $residentialUnitNight) => $residentialUnitNight->toArray(),
                $this->residentialUnitNights
            ) : null,
            'residentialUnits' => $this->residentialUnits,
        ];
    }
}
