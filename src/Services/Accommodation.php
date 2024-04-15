<?php

namespace TmrwLife\NtakGuru\Services;

use GuzzleHttp\RequestOptions;
use TmrwLife\NtakGuru\Entities\AccommodationProvider;
use TmrwLife\NtakGuru\Entities\AccommodationUrl;

class Accommodation extends NtakGuru
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function activate(string $accommodation): array
    {
        return $this->post("/v1/accommodations/$accommodation/activate");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deactivate(string $accommodation): array
    {
        return $this->post("/v1/accommodations/$accommodation/deactivate");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(int $page = 1, int $perPage = 25, ?string $query = null): array
    {
        return $this->get('/v1/accommodations', array_filter([
            'page' => $page,
            'perPage' => $perPage,
            'q' => $query,
        ]));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(string $accommodation): array
    {
        return $this->get("/v1/accommodations/$accommodation");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateProvider(string $accommodation, AccommodationProvider $entity): array
    {
        return $this->put("/v1/accommodations/$accommodation", [
            RequestOptions::JSON => $entity->toArray(),
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateUrl(string $accommodation, AccommodationUrl $entity): array
    {
        return $this->put("/v1/accommodations/$accommodation", [
            RequestOptions::JSON => $entity->toArray(),
        ]);
    }
}
