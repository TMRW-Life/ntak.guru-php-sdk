<?php

namespace TmrwLife\NtakGuru\Services\Reporting;

use TmrwLife\NtakGuru\Entities\Ntak\CheckIn;
use TmrwLife\NtakGuru\Entities\Ntak\CheckOut;
use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Entities\Ntak\RoomChange;
use TmrwLife\NtakGuru\Services\NtakGuru;

class Ntak extends NtakGuru
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkIn(string $accommodation, CheckIn $entity): array
    {
        return $this->post("/v1/accommodations/$accommodation/reports/ntak/check_in", $entity->toArray());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(string $accommodation, CheckOut $entity): array
    {
        return $this->post("/v1/accommodations/$accommodation/reports/ntak/check_out", $entity->toArray());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(string $accommodation, int $page = 1, int $perPage = 25): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/ntak", [
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reservation(string $accommodation, Reservation $entity): array
    {
        return $this->post("/v1/accommodations/$accommodation/reports/ntak/reservation", $entity->toArray());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function retry(string $accommodation, string $report, array $entity): array
    {
        return $this->put("/v1/accommodations/$accommodation/reports/ntak/$report", $entity);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function roomChange(string $accommodation, RoomChange $entity): array
    {
        return $this->post("/v1/accommodations/$accommodation/reports/ntak/room_change", $entity->toArray());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(string $accommodation, string $report): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/ntak/$report");
    }
}
