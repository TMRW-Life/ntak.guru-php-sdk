<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Ntak;

use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;
use TmrwLife\NtakGuru\Validation\Ntak\Validator;

class ReservationValidationTest extends TestCase
{
    use WithFaker;

    public function testItReservationValidationSuccess(): void
    {
        $reservation = (new Reservation())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setReservedAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setCancelled($this->faker->boolean())
            ->setNationality($this->faker->countryCode())
            ->setArrival($this->faker->dateTime()->format('Y-m-d'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setSalesChannel(SalesChannel::from($this->faker->randomElement(SalesChannel::values())))
            ->setMarketSegment(MarketSegment::from($this->faker->randomElement(MarketSegment::values())))
            ->setGrossAmount($this->faker->randomFloat(2, 0, 1000))
            ->setGuestCount($this->faker->numberBetween(1, 10))
            ->addBookedResidentialUnits(
                ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())),
                $this->faker->numberBetween(1, 10)
            );

        $validator = Validator::parse($reservation);

        $this->assertTrue($validator->validate());
    }

    public function testItReservationValidationFail(): void
    {
        $reservation = (new Reservation());

        $validator = Validator::parse($reservation);

        $this->assertFalse($validator->validate());

        $this->assertArrayHasKey('arrival', $validator->getErrors());
        $this->assertArrayHasKey('departure', $validator->getErrors());
        $this->assertArrayHasKey('cancelled', $validator->getErrors());
        $this->assertArrayHasKey('guestCount', $validator->getErrors());
        $this->assertArrayHasKey('reservationNumber', $validator->getErrors());
        $this->assertArrayHasKey('marketSegment', $validator->getErrors());
        $this->assertArrayHasKey('reservedAt', $validator->getErrors());
        $this->assertArrayHasKey('occurredAt', $validator->getErrors());
        $this->assertArrayHasKey('salesChannel', $validator->getErrors());
        $this->assertArrayHasKey('grossAmount', $validator->getErrors());
        $this->assertArrayHasKey('nationality', $validator->getErrors());
        $this->assertArrayHasKey('bookedResidentialUnits', $validator->getErrors());
    }
}
