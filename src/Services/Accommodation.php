<?php

namespace TmrwLife\NtakGuru\Services;

use GuzzleHttp\RequestOptions;
use TmrwLife\NtakGuru\Entities\Accommodation as AccommodationEntity;

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
    public function show(string $accommodation): array
    {
        return $this->get("/v1/accommodations/$accommodation");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(AccommodationEntity $accommodation): array
    {
        return $this->post('/v1/accommodations', [
            RequestOptions::JSON => $accommodation->toArray(),
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(string $accommodation, AccommodationEntity $entity): array
    {
        return $this->put("/v1/accommodations/$accommodation", [
            RequestOptions::JSON => $entity->toArray(),
        ]);
    }
}
