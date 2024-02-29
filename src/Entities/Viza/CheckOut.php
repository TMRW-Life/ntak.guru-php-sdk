<?php

namespace TmrwLife\NtakGuru\Entities\Viza;

use TmrwLife\NtakGuru\Interfaces\Context;

class CheckOut implements Context
{
    protected ?array $guests = null;
    protected ?string $occurredAt = null;

    public function addGuest(string|int $guestNumber, string $departure): CheckOut
    {
        $this->guests[] = [
            'guestNumber' => $guestNumber,
            'departure' => $departure,
        ];

        return $this;
    }

    public function setOccurredAt(string $occurredAt): CheckOut
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'guests' => $this->guests,
            'occurredAt' => $this->occurredAt,
        ];
    }
}
