<?php

namespace Checkout;

final class CheckoutConfiguration
{
    private SdkCredentialsInterface $sdkCredentials;

    private Environment $environment;

    private HttpClientBuilderInterface $httpClientBuilder;

    public function __construct(SdkCredentialsInterface    $sdkCredentials,
                                Environment                $environment,
                                HttpClientBuilderInterface $httpClientBuilder)
    {
        $this->sdkCredentials = $sdkCredentials;
        $this->environment = $environment;
        $this->httpClientBuilder = $httpClientBuilder;
    }

    public function getSdkCredentials(): SdkCredentialsInterface
    {
        return $this->sdkCredentials;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function getHttpClientBuilder(): HttpClientBuilderInterface
    {
        return $this->httpClientBuilder;
    }

}
