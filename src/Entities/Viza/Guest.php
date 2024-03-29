<?php

namespace TmrwLife\NtakGuru\Entities\Viza;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Guest implements Arrayable
{
    protected ?string $arrival = null;
    protected ?string $departure = null;
    protected string|int|null $guestNumber = null;
    protected ?GuestDocument $manual = null;
    protected ?GuestDocument $scanned = null;
    protected ?string $visaDateOfEntry = null;
    protected ?string $visaNumber = null;
    protected ?string $visaPlaceOfEntry = null;

    public function setArrival(string $arrival): Guest
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function setDeparture(string $departure): Guest
    {
        $this->departure = $departure;

        return $this;
    }

    public function setGuestNumber(string $id): Guest
    {
        $this->guestNumber = $id;

        return $this;
    }

    public function setManual(GuestDocument $manual): Guest
    {
        $this->manual = $manual;

        return $this;
    }

    public function setScanned(GuestDocument $scanned): Guest
    {
        $this->scanned = $scanned;

        return $this;
    }

    public function setVisaDateOfEntry(string $visaDateOfEntry): Guest
    {
        $this->visaDateOfEntry = $visaDateOfEntry;

        return $this;
    }

    public function setVisaNumber(string $visaNumber): Guest
    {
        $this->visaNumber = $visaNumber;

        return $this;
    }

    public function setVisaPlaceOfEntry(string $visaPlaceOfEntry): Guest
    {
        $this->visaPlaceOfEntry = $visaPlaceOfEntry;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'arrival' => $this->arrival,
            'departure' => $this->departure,
            'guestNumber' => $this->guestNumber,
            'manual' => $this->manual?->toArray(),
            'scanned' => $this->scanned?->toArray(),
            'visaDateOfEntry' => $this->visaDateOfEntry,
            'visaNumber' => $this->visaNumber,
            'visaPlaceOfEntry' => $this->visaPlaceOfEntry,
        ]);
    }
}
