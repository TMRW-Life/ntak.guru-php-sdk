<?php

namespace TmrwLife\NtakGuru\Tests\Traits;

use TmrwLife\NtakGuru\Enums\NtakCountry;

trait WithSafeCountry
{
    use WithFaker;

    protected function safeCountry(?string $country = null): NtakCountry
    {
        $country ??= $this->faker->countryCode();

        return NtakCountry::tryFrom($country) ?? NtakCountry::OTHER;
    }
}
