<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Enums\PaymentOption;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Expense implements Arrayable
{
    protected int|float $amount;
    protected string $date;
    protected PaymentOption $paymentOption;
    protected ?string $paymentOptionSubtype = null;

    public function setAmount(float|int $amount): Expense
    {
        $this->amount = $amount;

        return $this;
    }

    public function setDate(string $date): Expense
    {
        $this->date = $date;

        return $this;
    }

    public function setPaymentOption(PaymentOption $paymentOption): Expense
    {
        $this->paymentOption = $paymentOption;

        return $this;
    }

    public function setPaymentOptionSubtype(?string $paymentOptionSubtype): Expense
    {
        $this->paymentOptionSubtype = $paymentOptionSubtype;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'amount' => $this->amount,
            'date' => $this->date,
            'paymentOption' => $this->paymentOption->value,
        ];

        if ($this->paymentOption === PaymentOption::SZEP) {
            $data['paymentOptionSubtype'] = $this->paymentOptionSubtype;
        }

        return $data;
    }
}
