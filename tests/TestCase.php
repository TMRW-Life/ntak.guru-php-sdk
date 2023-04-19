<?php

namespace TmrwLife\NtakGuru\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        $this->setUpTraits();
    }

    protected function setUpTraits()
    {
        $uses = array_flip($this->class_uses_recursive(static::class));

        if (isset($uses[WithFaker::class])) {
            $this->setUpFaker();
        }

        return $uses;
    }

    protected function class_uses_recursive($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $results = [];

        foreach (array_reverse(class_parents($class)) + [$class => $class] as $class) {
            $results += $this->trait_uses_recursive($class);
        }

        return array_unique($results);
    }

    protected function trait_uses_recursive($trait)
    {
        $traits = class_uses($trait) ?: [];

        foreach ($traits as $trait) {
            $traits += $this->trait_uses_recursive($trait);
        }

        return $traits;
    }
}
