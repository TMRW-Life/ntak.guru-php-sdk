<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Ntak;

use TmrwLife\NtakGuru\Entities\Ntak\CheckOut;
use TmrwLife\NtakGuru\Entities\Ntak\Guest;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnit;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CheckOutValidationTest extends TestCase
{
    use WithFaker;

    public function testItCheckOutValidationSuccess(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setGuestNumber($this->faker->uuid())
            ->setYearOfBirth((int) $this->faker->year())
            ->setTouristTaxStatus(TouristTax::from($this->faker->randomElement(TouristTax::values())))
            ->setNationalityCountryCode($this->faker->countryCode())
            ->setResidencePostCode($this->faker->postcode())
            ->setResidenceCountryCode($this->faker->countryCode());

        $unit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())))
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $checkOut = (new CheckOut())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setAbandonedResidentialUnit($unit);

        $this->assertTrue($checkOut->validate());
    }

    public function testItCheckOutValidationFail(): void
    {
        $checkOut = (new CheckOut());

        $this->assertFalse($checkOut->validate());

        $this->assertArrayHasKey('occurredAt', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('reservationNumber', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('guests', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.type', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.building', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.number', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.singleBedCount', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.doubleBedCount', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.trundleBedCount', $checkOut->getValidationErrors());
    }
}
