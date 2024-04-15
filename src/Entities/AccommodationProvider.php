<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class AccommodationProvider implements Arrayable
{
    protected string $providerName;
    protected string $providerTaxNumber;

    public function setProviderName(string $providerName): AccommodationProvider
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function setProviderTaxNumber(string $providerTaxNumber): AccommodationProvider
    {
        $this->providerTaxNumber = $providerTaxNumber;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'providerName' => $this->providerName,
            'providerTaxNumber' => $this->providerTaxNumber,
        ];
    }
}
