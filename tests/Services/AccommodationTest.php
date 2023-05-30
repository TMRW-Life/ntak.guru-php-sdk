<?php

namespace TmrwLife\NtakGuru\Tests\Services;

use TmrwLife\NtakGuru\Entities\Accommodation as AccommodationEntity;
use TmrwLife\NtakGuru\Services\Accommodation;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class AccommodationTest extends TestCase
{
    use WithFaker;

    public function testItShowsTheAccommodation(): void
    {
        $gateway = Accommodation::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->show($id);

        $this->assertSame($id, $response['payload']['id']);
    }

    public function testItStoresTheAccommodation(): void
    {
        $accommodation = (new AccommodationEntity())
            ->setName($this->faker->company())
            ->setCountry($country = $this->faker->countryCode())
            ->setLocality($this->faker->city())
            ->setPostcode($this->faker->postcode())
            ->setProviderName($this->faker->name())
            ->setProviderTaxNumber($this->faker->iban($country));

        $gateway = Accommodation::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->store($accommodation);

        $this->assertSame($id, $response['payload']['id']);
    }

    public function testItUpdatesTheAccommodation(): void
    {
        $accommodation = (new AccommodationEntity())
            ->setName($this->faker->company())
            ->setCountry($country = $this->faker->countryCode())
            ->setLocality($this->faker->city())
            ->setPostcode($this->faker->postcode())
            ->setProviderName($this->faker->name())
            ->setProviderTaxNumber($this->faker->iban($country));

        $gateway = Accommodation::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->update($id, $accommodation);

        $this->assertSame($id, $response['payload']['id']);
    }

    public function testItActivatesTheAccommodation(): void
    {
        $gateway = Accommodation::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->activate($id);

        $this->assertSame($id, $response['payload']['id']);
    }

    public function testItDeactivatesTheAccommodation(): void
    {
        $gateway = Accommodation::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->deactivate($id);

        $this->assertSame($id, $response['payload']['id']);
    }
}
