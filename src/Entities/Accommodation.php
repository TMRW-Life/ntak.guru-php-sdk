<?php

namespace TmrwLife\NtakGuru\Entities;

use TmrwLife\NtakGuru\Interfaces\Arrayable;

class Accommodation implements Arrayable
{
    protected string $dailyCloseUrl;
    protected string|null $callbackUrl;

    public function setDailyCloseUrl(string $dailyCloseUrl): Accommodation
    {
        $this->dailyCloseUrl = $dailyCloseUrl;

        return $this;
    }

    public function setCallbackUrl(?string $callbackUrl = null): Accommodation
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
