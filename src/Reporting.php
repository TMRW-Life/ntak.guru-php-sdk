<?php

namespace TmrwLife\NtakGuru;

use TmrwLife\NtakGuru\Entities\CheckIn;
use TmrwLife\NtakGuru\Entities\CheckOut;
use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Entities\RoomChange;

class Reporting extends NtakGuru
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkIn(string $accommodation, CheckIn $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/check-in", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(string $accommodation, CheckOut $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/check-out", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reservation($accommodation, Reservation $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/reservation", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function roomChange($accommodation, RoomChange $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$accommodation/reports/room-change", $data);
    }
}
