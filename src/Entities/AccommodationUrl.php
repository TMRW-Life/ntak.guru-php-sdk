<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class AccommodationUrl implements Arrayable
{
    protected string $dailyCloseUrl;

    protected ?string $callbackUrl = null;

    public function setDailyCloseUrl(string $dailyCloseUrl): AccommodationUrl
    {
        $this->dailyCloseUrl = $dailyCloseUrl;

        return $this;
    }

    public function setCallbackUrl(string $callbackUrl = null): AccommodationUrl
    {
        $this->callbackUrl = $callbackUrl;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'dailyCloseUrl' => $this->dailyCloseUrl,
            'callbackUrl' => $this->callbackUrl,
        ];
    }
}
