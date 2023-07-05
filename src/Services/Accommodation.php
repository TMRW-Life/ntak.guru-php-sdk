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
    public function index(int $page = 1, int $perPage = 25): array
    {
        if ($perPage > 100) {
            $perPage = 100;
        }

        return $this->get("/v1/accommodations", [
            'page' => $page,
            'perPage' => $perPage,
        ]);
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
    public function update(string $accommodation, AccommodationEntity $entity): array
    {
        return $this->put("/v1/accommodations/$accommodation", [
            RequestOptions::JSON => $entity->toArray(),
        ]);
    }
}
