<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Viza;

use TmrwLife\NtakGuru\Entities\Viza\CheckOut;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CheckOutValidationTest extends TestCase
{
    use WithFaker;

    public function testItCheckOutValidationFail(): void
    {
        $checkOut = (new CheckOut());

        $this->assertFalse($checkOut->validate());

        $this->assertArrayHasKey('occurredAt', $checkOut->getValidationErrors());
        $this->assertArrayHasKey('guests', $checkOut->getValidationErrors());
    }

    public function testItCheckOutValidationSuccess(): void
    {
        $checkOut = (new CheckOut())
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest(
                id: $this->faker->uuid(),
                departure: $this->faker->dateTime()->format('Y-m-d H:i:s'),
            );

        $this->assertTrue($checkOut->validate());
    }
}
