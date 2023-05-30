<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Ntak;

use TmrwLife\NtakGuru\Entities\Ntak\Guest;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnit;
use TmrwLife\NtakGuru\Entities\Ntak\RoomChange;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;
use TmrwLife\NtakGuru\Validation\Ntak\Validator;

class RoomChangeValidationTest extends TestCase
{
    use WithFaker;

    public function testItRoomChangeValidationSuccess(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setGuestNumber($this->faker->uuid())
            ->setYearOfBirth((int) $this->faker->year())
            ->setTouristTaxStatus(TouristTax::from($this->faker->randomElement(TouristTax::values())))
            ->setNationalityCountryCode($this->faker->countryCode())
            ->setResidencePostCode($this->faker->postcode())
            ->setResidenceCountryCode($this->faker->countryCode());

        $unit1 = (new ResidentialUnit())
            ->setType(ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())))
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $unit2 = (new ResidentialUnit())
            ->setType(ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())))
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $checkOut = (new RoomChange())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setOccupiedResidentialUnit($unit1)
            ->setAbandonedResidentialUnit($unit2);

        $validator = Validator::parse($checkOut);

        $this->assertTrue($validator->validate());
    }

    public function testItRoomChangeValidationFail(): void
    {
        $checkOut = (new RoomChange());

        $validator = Validator::parse($checkOut);

        $this->assertFalse($validator->validate());

        $this->assertArrayHasKey('occurredAt', $validator->getErrors());
        $this->assertArrayHasKey('reservationNumber', $validator->getErrors());
        $this->assertArrayHasKey('guests', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.type', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.building', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.number', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.singleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.doubleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('occupiedResidentialUnit.trundleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.type', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.building', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.number', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.singleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.doubleBedCount', $validator->getErrors());
        $this->assertArrayHasKey('abandonedResidentialUnit.trundleBedCount', $validator->getErrors());
    }
}
