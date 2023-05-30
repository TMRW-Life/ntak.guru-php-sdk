<?php

namespace TmrwLife\NtakGuru\Entities\Viza;

use Illuminate\Contracts\Support\Arrayable;

class CheckIn implements Arrayable
{
    protected ?array $guests = null;
    protected ?string $occurredAt = null;

    public function addGuest(Guest $guests): CheckIn
    {
        $this->guests[] = $guests;

        return $this;
    }

    public function setOccurredAt(string $occurredAt): CheckIn
    {
        $this->occurredAt = $occurredAt;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'guests' => $this->guests ? array_map(static fn (Guest $guest) => $guest->toArray(), $this->guests) : null,
            'occurredAt' => $this->occurredAt,
        ];
    }
}
