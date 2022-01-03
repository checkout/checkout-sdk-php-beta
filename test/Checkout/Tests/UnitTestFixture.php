<?php

namespace Checkout\Tests;

use Checkout\ApiClient;
use Checkout\CheckoutConfiguration;
use Checkout\Environment;
use Checkout\HttpClientBuilderInterface;
use Checkout\SdkAuthorization;
use Checkout\SdkCredentialsInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class UnitTestFixture extends MockeryTestCase
{

    protected string $platformType;

    protected CheckoutConfiguration $configuration;

    /**
     * @var mixed
     */
    protected $apiClient;

    public function initMocks(string $platformType): void
    {
        $this->platformType = $platformType;
        $sdkAuthorization = new SdkAuthorization($platformType, "key");

        $sdkCredentials = $this->createMock(SdkCredentialsInterface::class);
        $sdkCredentials->method("getAuthorization")->willReturn($sdkAuthorization);

        $httpBuilder = $this->createMock(HttpClientBuilderInterface::class);

        $this->configuration = new CheckoutConfiguration($sdkCredentials, Environment::sandbox(), $httpBuilder);

        $this->apiClient = $this->createStub(ApiClient::class);
    }

}
