<?php

namespace Checkout\Tests;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotNull;

class CheckoutTestUtils
{

    /**
     * @param mixed $response
     * @param mixed ...$properties
     * @return void
     */
    public static function assertKeysResponse($response, ...$properties)
    {
        foreach ($properties as $property) {
            assertArrayHasKey($property, $response);
        }
    }

    /**
     * @param mixed $response
     * @param mixed ...$properties
     * @return void
     */
    public static function assertKeysWithNotNullsResponse($response, ...$properties)
    {
        foreach ($properties as $property) {
            assertArrayHasKey($property, $response);
            assertNotNull($response[$property]);
            assertNotEmpty($response[$property]);
        }
    }

}
