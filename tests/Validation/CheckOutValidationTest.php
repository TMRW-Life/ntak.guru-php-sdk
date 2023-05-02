<?php

namespace TmrwLife\NtakGuru\Tests\Validation;

use TmrwLife\NtakGuru\Entities\CheckOut;
use TmrwLife\NtakGuru\Entities\Guest;
use TmrwLife\NtakGuru\Entities\ResidentialUnit;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;
use TmrwLife\NtakGuru\Validation\Validator;

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

        $validator = Validator::parse($checkOut);

        $this->assertTrue($validator->validate());
    }

    public function testItCheckOutValidationFail(): void
    {
        $checkOut = (new CheckOut());

        $validator = Validator::parse($checkOut);

        $this->assertFalse($validator->validate());

        $this->assertArrayHasKey('occurredAt', $validator->getErrors());
        $this->assertArrayHasKey('reservationNumber', $validator->getErrors());
        $this->assertArrayHasKey('guests', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.type', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.building', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.number', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.singleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.doubleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.trundleBedCount', $validator->getErrors());
    }
}
