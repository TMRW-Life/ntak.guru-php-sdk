<?php

namespace TmrwLife\NtakGuru\Entities\Viza;

use TmrwLife\NtakGuru\Context;

class CheckOut extends Context
{
    protected ?array $guests = null;
    protected ?string $occurredAt = null;

    public function addGuest(string $id, string $departure): CheckOut
    {
        $this->guests[] = [
            'id' => $id,
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
