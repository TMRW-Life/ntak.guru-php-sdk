<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class ResidentialUnit implements Arrayable
{
    protected string $building;

    protected int $doubleBedCount;

    protected int|string $number;

    protected int $singleBedCount;

    protected int $trundleBedCount;

    protected ResidentialUnitType $type;

    public function setBuilding(string $building): ResidentialUnit
    {
        $this->building = $building;

        return $this;
    }

    public function setDoubleBedCount(int $doubleBedCount): ResidentialUnit
    {
        $this->doubleBedCount = $doubleBedCount;

        return $this;
    }

    public function setNumber(int|string $number): ResidentialUnit
    {
        $this->number = $number;

        return $this;
    }

    public function setSingleBedCount(int $singleBedCount): ResidentialUnit
    {
        $this->singleBedCount = $singleBedCount;

        return $this;
    }

    public function setTrundleBedCount(int $trundleBedCount): ResidentialUnit
    {
        $this->trundleBedCount = $trundleBedCount;

        return $this;
    }

    public function setType(ResidentialUnitType $type): ResidentialUnit
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'building' => $this->building,
            'number' => $this->number,
            'trundleBedCount' => $this->trundleBedCount,
            'singleBedCount' => $this->singleBedCount,
            'doubleBedCount' => $this->doubleBedCount,
        ];
    }
}
