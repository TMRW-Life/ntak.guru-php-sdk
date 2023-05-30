<?php

namespace TmrwLife\NtakGuru\Entities\Viza;

use Illuminate\Contracts\Support\Arrayable;

class CheckOut implements Arrayable
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
