<?php

namespace Tests\Unit\Exceptions;

use PHPUnit\Framework\TestCase;

class PHPExtensionsTest extends TestCase
{
    public function test_gd_extension_is_enabled(): void
    {
        $gdExtensionIsLoaded = extension_loaded('gd');

        $this->assertTrue($gdExtensionIsLoaded, 'PHP extension gd is not loaded! Check GD in phpinfo.');
    }
}
