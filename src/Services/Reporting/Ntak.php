<?php

namespace TmrwLife\NtakGuru\Services\Reporting;

use TmrwLife\NtakGuru\Crypt;
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
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/ntak/check-in", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(string $accommodation, CheckOut $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/ntak/check-out", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index(string $accommodation, int $page = 1, int $perPage = 25): array
    {
        if ($perPage > 100) {
            $perPage = 100;
        }

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
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/ntak/reservation", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function retry(string $accommodation, string $report, array $entity): array
    {
        $data = Crypt::seal($entity);

        return $this->put("/v1/accommodations/$accommodation/reports/ntak/$report", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function roomChange(string $accommodation, RoomChange $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/ntak/room-change", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function show(string $accommodation, string $report): array
    {
        return $this->get("/v1/accommodations/$accommodation/reports/ntak/$report");
    }
}
