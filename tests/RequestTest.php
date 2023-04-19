<?php

namespace TmrwLife\NtakGuru\Tests;

use GuzzleHttp\Exception\ClientException;
use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnit;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\NtakGuru;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class RequestTest extends TestCase
{
    use WithFaker;

    public function testItSendsRequest(): void
    {
        $reservation = (new Reservation())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setReservedAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setCancelled($this->faker->boolean())
            ->setNationality($this->faker->countryCode())
            ->setArrival($this->faker->dateTime()->format('Y-m-d'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setSalesChannel(SalesChannel::DIRECTLY_ONLINE)
            ->setMarketSegment(MarketSegment::BUSINESS_GROUP)
            ->setGrossAmount($this->faker->randomFloat(2, 0, 1000))
            ->setGuestCount($this->faker->randomNumber(1))
            ->addBookedResidentialUnits(ResidentialUnit::APARTMENT, $this->faker->randomNumber(1));

        $ntakGuru = NtakGuru::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
                'messageId' => $messageId = $this->faker->uuid(),
                'status' => 'pending',
                'reason' => $reason = $this->faker->word(),
                'type' => 'reservation',
                'context' => 'context',
                'response' => null,
            ],
        ]);

        $report = $ntakGuru->reservation($reservation);

        $this->assertSame($id, $report['payload']['id']);
        $this->assertSame($messageId, $report['payload']['messageId']);
        $this->assertSame('pending', $report['payload']['status']);
        $this->assertSame($reason, $report['payload']['reason']);
        $this->assertSame('reservation', $report['payload']['type']);
        $this->assertSame('context', $report['payload']['context']);
        $this->assertNull($report['payload']['response']);
    }

    public function testItThrowsExceptionIfTheRequestFails(): void
    {
        $reservation = (new Reservation())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setReservedAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setCancelled($this->faker->boolean())
            ->setNationality($this->faker->countryCode())
            ->setArrival($this->faker->dateTime()->format('Y-m-d'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setSalesChannel(SalesChannel::DIRECTLY_ONLINE)
            ->setMarketSegment(MarketSegment::BUSINESS_GROUP)
            ->setGrossAmount($this->faker->randomFloat(2, 0, 1000))
            ->setGuestCount($this->faker->randomNumber(1))
            ->addBookedResidentialUnits(ResidentialUnit::APARTMENT, $this->faker->randomNumber(1));

        $ntakGuru = NtakGuru::fake([], 404);

        $this->expectException(ClientException::class);
        $ntakGuru->reservation($reservation);
    }
}
