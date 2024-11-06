<?php

namespace TmrwLife\NtakGuru\Tests\Entities\Viza;

use TmrwLife\NtakGuru\Entities\Viza\CheckOut;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CheckOutTest extends TestCase
{
    use WithFaker;

    public function testItBuildsTheCheckOutArray(): void
    {
        $checkOut = (new CheckOut())
            ->setOccurredAt($occurredAt = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest(
                id: $guestId = $this->faker->uuid(),
                departure: $departure = $this->faker->dateTime()->format('Y-m-d H:i:s'),
            );

        $this->assertSame([
            'guests' => [
                [
                    'id' => $guestId,
                    'departure' => $departure,
                ],
            ],
            'occurredAt' => $occurredAt,
        ], $checkOut->toArray());
    }
}
