<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Enums\ChargeItemCategory;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Load implements Arrayable
{
    protected int|float $amount;
    protected ChargeItemCategory $category;
    protected string $date;
    protected bool $isTouristTax = false;
    protected int $taxPercentage;

    public function setAmount(float|int $amount): Load
    {
        $this->amount = $amount;

        return $this;
    }

    public function setCategory(ChargeItemCategory $category): Load
    {
        $this->category = $category;

        return $this;
    }

    public function setDate(string $date): Load
    {
        $this->date = $date;

        return $this;
    }

    public function setIsTouristTax(bool $isTouristTax): Load
    {
        $this->isTouristTax = $isTouristTax;

        return $this;
    }

    public function setTaxPercentage(int $taxPercentage): Load
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'category' => $this->category->value,
            'date' => $this->date,
            'isTouristTax' => $this->isTouristTax,
            'taxPercentage' => $this->taxPercentage,
        ];
    }
}
