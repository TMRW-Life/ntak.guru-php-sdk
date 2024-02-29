<?php

namespace TmrwLife\NtakGuru\Services\Reporting;

use TmrwLife\NtakGuru\Entities\Viza\CheckIn;
use TmrwLife\NtakGuru\Entities\Viza\CheckOut;
use TmrwLife\NtakGuru\Services\NtakGuru;

class Viza extends NtakGuru
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkIn(string $accommodation, CheckIn $entity): array
    {
        return $this->post("/v1/accommodations/$accommodation/reports/viza/check_in", $entity->toArray());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(string $accommodation, CheckOut $entity): array
    {
        return $this->post("/v1/accommodations/$accommodation/reports/viza/check_out", $entity->toArray());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(string $accommodation, int $page = 1, int $perPage = 25): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/viza", [
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function retry(string $accommodation, string $report, array $entity): array
    {
        return $this->put("/v1/accommodations/$accommodation/reports/viza/$report", $entity);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(string $accommodation, string $report): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/viza/$report");
    }
}
