<?php

namespace TmrwLife\NtakGuru\Tests\Entities;

use TmrwLife\NtakGuru\Entities\CheckIn;
use TmrwLife\NtakGuru\Entities\Guest;
use TmrwLife\NtakGuru\Entities\ResidentialUnit;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\ResidentialUnit as ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CheckInTest extends TestCase
{
    use WithFaker;

    public function testItBuildsTheCheckInArray(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::MALE)
            ->setGuestNumber($guestNumber = $this->faker->uuid())
            ->setYearOfBirth($yearOfBirth = (int) $this->faker->year())
            ->setTouristTaxStatus(TouristTax::OBLIGED)
            ->setNationalityCountryCode($nationality = $this->faker->countryCode())
            ->setResidencePostCode($postCode = $this->faker->postcode())
            ->setResidenceCountryCode($country = $this->faker->countryCode());

        $unit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($building = $this->faker->randomLetter())
            ->setNumber($number = $this->faker->randomNumber(2))
            ->setSingleBedCount($single = $this->faker->randomNumber(1))
            ->setDoubleBedCount($double = $this->faker->randomNumber(1))
            ->setTrundleBedCount($trundle = $this->faker->randomNumber(1));

        $checkIn = (new CheckIn())
            ->setReservationNumber($reservationNumber = $this->faker->numerify('#####'))
            ->setOccurredAt($occurredAt = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setOccupiedResidentialUnit($unit);

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
            'occupiedResidentialUnit' => [
                'type' => ResidentialUnitType::APARTMENT->value,
                'building' => $building,
                'number' => $number,
                'trundleBedCount' => $trundle,
                'singleBedCount' => $single,
                'doubleBedCount' => $double,
            ],
        ], $checkIn->toArray());
    }
}
