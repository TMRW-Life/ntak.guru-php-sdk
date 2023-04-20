<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Accommodation implements Arrayable
{
    protected string $country;
    protected string $locality;
    protected string $name;
    protected string $postcode;
    protected string $providerName;
    protected string $providerTaxNumber;

    public function setCountry(string $country): Accommodation
    {
        $this->country = $country;

        return $this;
    }

    public function setLocality(string $locality): Accommodation
    {
        $this->locality = $locality;

        return $this;
    }

    public function setName(string $name): Accommodation
    {
        $this->name = $name;

        return $this;
    }

    public function setPostcode(string $postcode): Accommodation
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function setProviderName(string $providerName): Accommodation
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function setProviderTaxNumber(string $providerTaxNumber): Accommodation
    {
        $this->providerTaxNumber = $providerTaxNumber;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'country' => $this->country,
            'locality' => $this->locality,
            'name' => $this->name,
            'postcode' => $this->postcode,
            'providerName' => $this->providerName,
            'providerTaxNumber' => $this->providerTaxNumber,
        ];
    }
}
