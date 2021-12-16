<?php

namespace Checkout;

abstract class AbstractCheckoutSdkBuilder
{

    protected Environment $environment;

    protected HttpClientBuilderInterface $httpClientBuilder;

    public function __construct()
    {
        $this->environment = Environment::sandbox();
        $this->httpClientBuilder = new DefaultHttpClientBuilder();
    }

    public function setEnvironment(Environment $environment): void
    {
        $this->environment = $environment;
    }

    public function setHttpClientBuilder(HttpClientBuilderInterface $httpClientBuilder): void
    {
        $this->httpClientBuilder = $httpClientBuilder;
    }

    protected function getCheckoutConfiguration(): CheckoutConfiguration
    {
        return new CheckoutConfiguration($this->getSdkCredentials(), $this->environment, $this->httpClientBuilder);
    }

    protected abstract function getSdkCredentials(): SdkCredentialsInterface;

    /**
     * @return mixed
     */
    protected abstract function build();

}
