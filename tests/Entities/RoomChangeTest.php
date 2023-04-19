<?php

namespace TmrwLife\NtakGuru\Tests\Entities;

use TmrwLife\NtakGuru\Entities\Guest;
use TmrwLife\NtakGuru\Entities\ResidentialUnit;
use TmrwLife\NtakGuru\Entities\RoomChange;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class RoomChangeTest extends TestCase
{
    use WithFaker;

    public function testItBuildsTheRoomChangeArray(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::MALE)
            ->setGuestNumber($guestNumber = $this->faker->uuid())
            ->setYearOfBirth($yearOfBirth = (int) $this->faker->year())
            ->setTouristTaxStatus(TouristTax::OBLIGED)
            ->setNationalityCountryCode($nationality = $this->faker->countryCode())
            ->setResidencePostCode($postCode = $this->faker->postcode())
            ->setResidenceCountryCode($country = $this->faker->countryCode());

        $unit1 = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($building1 = $this->faker->randomLetter())
            ->setNumber($number1 = $this->faker->randomNumber(2))
            ->setSingleBedCount($single1 = $this->faker->randomNumber(1))
            ->setDoubleBedCount($double1 = $this->faker->randomNumber(1))
            ->setTrundleBedCount($trundle1 = $this->faker->randomNumber(1));

        $unit2 = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($building2 = $this->faker->randomLetter())
            ->setNumber($number2 = $this->faker->randomNumber(2))
            ->setSingleBedCount($single2 = $this->faker->randomNumber(1))
            ->setDoubleBedCount($double2 = $this->faker->randomNumber(1))
            ->setTrundleBedCount($trundle2 = $this->faker->randomNumber(1));

        $roomChange = (new RoomChange())
            ->setReservationNumber($reservationNumber = $this->faker->numerify('#####'))
            ->setOccurredAt($occurredAt = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setOccupiedResidentialUnit($unit1)
            ->setAbandonedResidentialUnit($unit2);

        $this->assertSame([
            'reservationNumber' => $reservationNumber,
            'occurredAt' => $occurredAt,
            'guests' => [
                [
                    'gender' => Gender::MALE->value,
                    'guestNumber' => $guestNumber,
                    'touristTaxStatus' => TouristTax::OBLIGED->value,
                    'yearOfBirth' => $yearOfBirth,
                    'residenceCountryCode' => $country,
                    'residencePostCode' => $postCode,
                    'nationalityCountryCode' => $nationality,
                ],
            ],
            'abandonedResidentialUnit' => [
                'type' => ResidentialUnitType::APARTMENT->value,
                'building' => $building2,
                'number' => $number2,
                'trundleBedCount' => $trundle2,
                'singleBedCount' => $single2,
                'doubleBedCount' => $double2,
            ],
            'occupiedResidentialUnit' => [
                'type' => ResidentialUnitType::APARTMENT->value,
                'building' => $building1,
                'number' => $number1,
                'trundleBedCount' => $trundle1,
                'singleBedCount' => $single1,
                'doubleBedCount' => $double1,
            ],
        ], $roomChange->toArray());
    }
}
