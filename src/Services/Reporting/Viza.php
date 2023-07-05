<?php

namespace TmrwLife\NtakGuru\Services\Reporting;

use TmrwLife\NtakGuru\Crypt;
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
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/viza/check-in", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(string $accommodation, CheckOut $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/viza/check-out", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(string $accommodation, int $page = 1, int $perPage = 25): array
    {
        if ($perPage > 100) {
            $perPage = 100;
        }

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
        $data = Crypt::seal($entity);

        return $this->put("/v1/accommodations/$accommodation/reports/viza/$report", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(string $accommodation, string $report): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/viza/$report");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function status(string $accommodation): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/viza/status");
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unsentData(string $accommodation): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/viza/unsent-data");
    }
}
