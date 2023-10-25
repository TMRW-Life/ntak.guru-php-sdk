<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Ntak;

use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

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

        $this->assertTrue($reservation->validate());
    }

    public function testItReservationValidationFail(): void
    {
        $reservation = (new Reservation());

        $this->assertFalse($reservation->validate());

        $this->assertArrayHasKey('arrival', $reservation->getValidationErrors());
        $this->assertArrayHasKey('departure', $reservation->getValidationErrors());
        $this->assertArrayHasKey('cancelled', $reservation->getValidationErrors());
        $this->assertArrayHasKey('guestCount', $reservation->getValidationErrors());
        $this->assertArrayHasKey('reservationNumber', $reservation->getValidationErrors());
        $this->assertArrayHasKey('marketSegment', $reservation->getValidationErrors());
        $this->assertArrayHasKey('reservedAt', $reservation->getValidationErrors());
        $this->assertArrayHasKey('occurredAt', $reservation->getValidationErrors());
        $this->assertArrayHasKey('salesChannel', $reservation->getValidationErrors());
        $this->assertArrayHasKey('grossAmount', $reservation->getValidationErrors());
        $this->assertArrayHasKey('nationality', $reservation->getValidationErrors());
        $this->assertArrayHasKey('bookedResidentialUnits', $reservation->getValidationErrors());
    }
}
