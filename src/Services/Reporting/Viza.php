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
}
