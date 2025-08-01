<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function checkAvailabilityGDExtension(): void
    {
        if (!extension_loaded('gd')) {
            $this->markTestSkipped('The GD extension is not enabled or installed.');
        }
    }
}
