<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Ntak;

use TmrwLife\NtakGuru\Entities\Ntak\CheckIn;
use TmrwLife\NtakGuru\Entities\Ntak\Guest;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnit;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CheckInValidationTest extends TestCase
{
    use WithFaker;

    public function testItCheckInValidationSuccess(): void
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

        $checkIn = (new CheckIn())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setOccupiedResidentialUnit($unit);

        $this->assertTrue($checkIn->validate());
    }

    public function testItCheckInValidationFail(): void
    {
        $checkIn = (new CheckIn());

        $this->assertFalse($checkIn->validate());

        $this->assertArrayHasKey('occurredAt', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('reservationNumber', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('guests', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.type', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.building', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.number', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.singleBedCount', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.doubleBedCount', $checkIn->getValidationErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.trundleBedCount', $checkIn->getValidationErrors());
    }
}
