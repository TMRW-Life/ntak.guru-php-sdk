<?php

namespace TmrwLife\NtakGuru;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;

abstract class NtakGuru
{
    protected Client $client;

    public function __construct(protected string $accessToken, HandlerStack $handlerStack = null)
    {
        $this->setupClient($handlerStack);
    }

    public static function fake(array $response, int $status = 200): static
    {
        $mock = new MockHandler([
            new Response($status, [], json_encode($response)),
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new static('not important', $handlerStack);
    }

    public static function setup(string $accessToken): static
    {
        return new static($accessToken);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function delete(string $endpoint): void
    {
        $this->client->delete($endpoint);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function get(string $endpoint, array $data = []): array
    {
        $response = $this->client->get($endpoint, [
            RequestOptions::QUERY => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function post(string $endpoint, array $data): array
    {
        $response = $this->client->post($endpoint, [
            RequestOptions::JSON => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function put(string $endpoint, array $data): array
    {
        $response = $this->client->put($endpoint, [
            RequestOptions::JSON => $data,
        ]);

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
