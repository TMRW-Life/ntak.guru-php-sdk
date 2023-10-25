<?php

namespace TmrwLife\NtakGuru\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

abstract class NtakGuru
{
    protected Client $client;

    /**
     * @param  array{accessToken: string, handlerStack: HandlerStack, isProduction: bool}  $config
     */
    public function __construct(protected array $config)
    {
        if (!array_key_exists('accessToken', $this->config)) {
            throw new InvalidArgumentException('Missing access token.');
        }

        $this->setupClient();
    }

    public static function fake(?array $response, int $status = 200): static
    {
        $mock = new MockHandler([
            new Response($status, [], json_encode($response)),
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new static([
            'accessToken' => 'not important',
            'handlerStack' => $handlerStack,
            'isProduction' => false,
        ]);
    }

    /**
     * @param  array{accessToken: string, isProduction: bool}  $config
     */
    public static function setup(array $config): static
    {
        return new static($config);
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
    protected function post(string $endpoint, array $data = []): array
    {
        $response = $this->client->post($endpoint, [
            RequestOptions::JSON => $data,
        ]);

        return json_decode($response->getBody(), true) ?? [];
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

    protected function setupClient(): void
    {
        if (
            array_key_exists('isProduction', $this->config) &&
            filter_var($this->config['isProduction'], FILTER_VALIDATE_BOOLEAN)
        ) {
            $domain = 'https://api.ntak.guru';
        } else {
            $domain = 'https://api.sandbox.ntak.guru';
        }

        $config = [
            'base_uri' => $domain,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$this->config['accessToken']}",
            ],
        ];

        if (array_key_exists('handlerStack', $this->config)) {
            $config['handler'] = $this->config['handlerStack'];
        }

        $this->client = new Client($config);
    }
}
