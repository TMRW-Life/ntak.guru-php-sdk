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
    public function checkIn(CheckIn $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$this->accommodationId/reports/check-in", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkOut(CheckOut $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$this->accommodationId/reports/check-out", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function reservation(Reservation $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$this->accommodationId/reports/reservation", $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function roomChange(RoomChange $entity): array
    {
        $data = Crypt::seal($entity->toArray());

        return $this->post("/v1/accommodations/$this->accommodationId/reports/room-change", $data);
    }
}
