<?php

namespace TmrwLife\NtakGuru\Entities\Ntak;

use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Guest implements Arrayable
{
    protected Gender $gender;

    protected int|string $guestNumber;

    protected string $nationalityCountryCode;

    protected string $residenceCountryCode;

    protected string $residencePostCode;

    protected TouristTax $touristTaxStatus;

    protected int $yearOfBirth;

    public function setGender(Gender $gender): Guest
    {
        $this->gender = $gender;

        return $this;
    }

    public function setGuestNumber(int|string $guestNumber): Guest
    {
        $this->guestNumber = $guestNumber;

        return $this;
    }

    public function setNationalityCountryCode(string $nationalityCountryCode): Guest
    {
        $this->nationalityCountryCode = $nationalityCountryCode;

        return $this;
    }

    public function setResidenceCountryCode(string $residenceCountryCode): Guest
    {
        $this->residenceCountryCode = $residenceCountryCode;

        return $this;
    }

    public function setResidencePostCode(string $residencePostCode): Guest
    {
        $this->residencePostCode = $residencePostCode;

        return $this;
    }

    public function setTouristTaxStatus(TouristTax $touristTaxStatus): Guest
    {
        $this->touristTaxStatus = $touristTaxStatus;

        return $this;
    }

    public function setYearOfBirth(int $yearOfBirth): Guest
    {
        $this->yearOfBirth = $yearOfBirth;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'gender' => $this->gender->value,
            'guestNumber' => $this->guestNumber,
            'touristTaxStatus' => $this->touristTaxStatus->value,
            'yearOfBirth' => $this->yearOfBirth,
            'residenceCountryCode' => $this->residenceCountryCode,
            'residencePostCode' => $this->residencePostCode,
            'nationalityCountryCode' => $this->nationalityCountryCode,
        ];
    }
}
