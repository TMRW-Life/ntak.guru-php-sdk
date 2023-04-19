<?php

namespace TmrwLife\NtakGuru\Tests\Traits;

use Faker\Factory;
use Faker\Generator;

trait WithFaker
{
    protected Generator $faker;

    protected function faker(string $locale = null): Generator
    {
        return is_null($locale) ? $this->faker : $this->makeFaker($locale);
    }

    protected function makeFaker(string $locale = null): Generator
    {
        return Factory::create($locale ?? Factory::DEFAULT_LOCALE);
    }

    protected function setUpFaker(): void
    {
        $this->faker = $this->makeFaker();
    }
}
