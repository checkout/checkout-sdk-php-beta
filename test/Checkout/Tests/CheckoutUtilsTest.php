<?php

namespace Checkout\Tests;

use Checkout\CheckoutUtils;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotNull;

class CheckoutUtilsTest extends TestCase
{
    /**
     * @test
     */
    public static function shouldGetVersion(): void
    {
        $version = CheckoutUtils::getVersion();
        assertNotEmpty($version);
        assertNotNull($version);
    }
}
