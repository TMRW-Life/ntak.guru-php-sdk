<?php

namespace TmrwLife\NtakGuru\Tests\Entities;

use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnit;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class ReservationTest extends TestCase
{
    use WithFaker;

    public function testItBuildsTheReservationArray(): void
    {
        $reservation = (new Reservation())
            ->setReservationNumber($reservationNumber = $this->faker->numerify('#####'))
            ->setOccurredAt($occurredAt = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setReservedAt($reservedAt = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setCancelled($cancelled = $this->faker->boolean())
            ->setNationality($nationality = $this->faker->countryCode())
            ->setArrival($arrival = $this->faker->dateTime()->format('Y-m-d'))
            ->setDeparture($departure = $this->faker->dateTime()->format('Y-m-d'))
            ->setSalesChannel($salesChannel = SalesChannel::DIRECTLY_ONLINE)
            ->setMarketSegment($marketSegment = MarketSegment::BUSINESS_GROUP)
            ->setGrossAmount($grossAmount = $this->faker->randomFloat(2, 0, 1000))
            ->setGuestCount($guestCount = $this->faker->randomNumber(1))
            ->addBookedResidentialUnits(ResidentialUnit::APARTMENT, $capacity = $this->faker->randomNumber(1));

        $this->assertSame([
            'reservationNumber' => $reservationNumber,
            'occurredAt' => $occurredAt,
            'reservedAt' => $reservedAt,
            'cancelled' => $cancelled,
            'nationality' => $nationality,
            'arrival' => $arrival,
            'departure' => $departure,
            'salesChannel' => $salesChannel->value,
            'marketSegment' => $marketSegment->value,
            'grossAmount' => $grossAmount,
            'guestCount' => $guestCount,
            'bookedResidentialUnits' => [
                [
                    'type' => ResidentialUnit::APARTMENT->value,
                    'capacity' => $capacity,
                ],
            ],
        ], $reservation->toArray());
    }
}
