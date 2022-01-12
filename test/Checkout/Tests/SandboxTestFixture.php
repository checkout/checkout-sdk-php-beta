<?php

namespace Checkout\Tests;

use Checkout\CheckoutApi;
use Checkout\CheckoutArgumentException;
use Checkout\CheckoutDefaultSdk;
use Checkout\CheckoutFourSdk;
use Checkout\Environment;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertNotNull;

abstract class SandboxTestFixture extends TestCase
{

    protected CheckoutApi $defaultApi;
    protected \Checkout\Four\CheckoutApi $fourApi;

    protected const MESSAGE_404 = "The API response status code (404) does not indicate success.";

    /**
     * @before
     * @throws CheckoutArgumentException
     */
    public function initDefaultApi(): void
    {
        $builder = CheckoutDefaultSdk::staticKeys();
        $builder->setPublicKey(getenv("CHECKOUT_PUBLIC_KEY"));
        $builder->setSecretKey(getenv("CHECKOUT_SECRET_KEY"));
        $builder->setEnvironment(Environment::sandbox());
        $this->defaultApi = $builder->build();

        $builder = CheckoutFourSdk::staticKeys();
        $builder->setPublicKey(getenv("CHECKOUT_FOUR_PUBLIC_KEY"));
        $builder->setSecretKey(getenv("CHECKOUT_FOUR_SECRET_KEY"));
        $builder->setEnvironment(Environment::sandbox());
        $this->fourApi = $builder->build();
    }

    protected function assertResponse($obj, ...$properties): void // @phpstan-ignore-line
    {
        assertNotNull($obj);
        assertNotEmpty($properties);
        foreach ($properties as $property) {
            if (str_contains($property, ".")) {
                // "a.b.c" to "a","b","c"
                $props = explode(".", $property);
                // value("a")
                $testingObj = $obj[$props[0]];
                // collect to "b.c"
                $joined = implode(".", array_slice($props, 1));
                self::assertResponse($testingObj, $joined);
            } else {
                //echo "\e[0;30;45massertResponse[property] testing=" . json_encode($property) . " found=" . json_encode($obj[$property]) . "\n";
                assertNotNull($obj[$property]);
                assertNotEmpty($obj[$property]);
            }
        }
    }

    protected function nap(int $seconds = 5): void
    {
        sleep($seconds);
    }

    protected function randomEmail(): string
    {
        return uniqid() . "@checkout-sdk-net.com";
    }

}
