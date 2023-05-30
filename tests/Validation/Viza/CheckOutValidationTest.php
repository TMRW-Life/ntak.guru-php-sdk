<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Viza;

use TmrwLife\NtakGuru\Entities\Viza\CheckOut;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;
use TmrwLife\NtakGuru\Validation\Viza\Validator;

class CheckOutValidationTest extends TestCase
{
    use WithFaker;

    public function testItCheckOutValidationFail(): void
    {
        $checkOut = (new CheckOut());

        $validator = Validator::parse($checkOut);

        $this->assertFalse($validator->validate());

        $this->assertArrayHasKey('occurredAt', $validator->getErrors());
        $this->assertArrayHasKey('guests', $validator->getErrors());
    }

    public function testItCheckOutValidationSuccess(): void
    {
        $checkOut = (new CheckOut())
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest(
                id: $this->faker->uuid(),
                departure: $this->faker->dateTime()->format('Y-m-d H:i:s'),
            );

        $validator = Validator::parse($checkOut);

        $this->assertTrue($validator->validate());
    }
}
