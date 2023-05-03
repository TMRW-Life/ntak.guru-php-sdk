<?php

namespace TmrwLife\NtakGuru\Validation\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use TmrwLife\NtakGuru\Enums\PaymentOption;

class PaymentOptionSubtypeRule implements ValidationRule, DataAwareRule
{
    protected array $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $segments = explode('.', $attribute);

        array_pop($segments);

        $key = implode('.', $segments).'.paymentOption';

        $paymentOption = PaymentOption::tryFrom(Arr::get($this->data, $key));

        if ($paymentOption === PaymentOption::SZEP && !$value) {
            $fail('validation.required_if')->translate([
                'attribute' => $attribute,
                'other' => $key,
                'value' => PaymentOption::SZEP->value,
            ]);
        }
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
