<?php

namespace TmrwLife\NtakGuru\Tests\Services;

use TmrwLife\NtakGuru\Entities\Accommodation as AccommodationEntity;
use TmrwLife\NtakGuru\Services\Accommodation;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class AccommodationTest extends TestCase
{
    use WithFaker;

    public function testItListsTheAccommodations(): void
    {
        $gateway = Accommodation::fake([
            'payload' => [
                ['id' => $id0 = $this->faker->uuid()],
                ['id' => $id1 = $this->faker->uuid()],
            ],
        ]);

        $response = $gateway->index();

        $this->assertSame($id0, $response['payload'][0]['id']);
        $this->assertSame($id1, $response['payload'][1]['id']);
    }

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

    public function testItUpdatesTheAccommodation(): void
    {
        $accommodation = (new AccommodationEntity())
            ->setCallbackUrl($this->faker->url())
            ->setDailyCloseUrl($this->faker->url());

        $gateway = Accommodation::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
                'callbackUrl' => $callbackUrl = $this->faker->uuid(),
                'dailyCloseUrl' => $dailyCloseUrl = $this->faker->uuid(),
            ],
        ]);

        $response = $gateway->update($id, $accommodation);

        $this->assertSame($id, $response['payload']['id']);
        $this->assertSame($callbackUrl, $response['payload']['callbackUrl']);
        $this->assertSame($dailyCloseUrl, $response['payload']['dailyCloseUrl']);
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
