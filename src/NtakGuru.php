<?php

namespace TmrwLife\NtakGuru;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use TmrwLife\NtakGuru\Entities\CheckIn;
use TmrwLife\NtakGuru\Entities\CheckOut;
use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Entities\RoomChange;
use TmrwLife\NtakGuru\Interfaces\Arrayable;

class NtakGuru
{
    protected Client $client;

    public function __construct(
        protected string $accommodationId,
        protected string $accessToken,
        HandlerStack $handlerStack = null
    ) {
        $this->setupClient($handlerStack);
    }

    public static function accommodation(string $accommodationId, string $accessToken): static
    {
        return new static($accommodationId, $accessToken);
    }

    public static function fake(array $response, int $status = 200): static
    {
        $mock = new MockHandler([
            new Response($status, [], json_encode($response)),
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new static('not important', 'not important', $handlerStack);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkIn(CheckIn $entity): array
    {
        return $this->sendRequest($entity, 'check-in');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(CheckOut $entity): array
    {
        return $this->sendRequest($entity, 'check-out');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reservation(Reservation $entity): array
    {
        return $this->sendRequest($entity, 'reservation');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function roomChange(RoomChange $entity): array
    {
        return $this->sendRequest($entity, 'room-change');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest(Arrayable $entity, string $endpoint): array
    {
        $data = Crypt::seal($entity);

        $response = $this->client
            ->post("v1/accommodations/$this->accommodationId/reports/$endpoint", $data);

        return json_decode($response->getBody(), true);
    }

    protected function setupClient(?HandlerStack $handlerStack): void
    {
        $config = [
            'base_uri' => 'https://api.ntak.guru',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->accessToken,
            ],
        ];

        if ($handlerStack) {
            $config['handler'] = $handlerStack;
        }

        $this->client = new Client($config);
    }
}
