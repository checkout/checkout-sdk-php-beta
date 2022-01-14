<?php

namespace Checkout;

abstract class AbstractCheckoutSdkBuilder
{

    protected ?string $publicKey = null;
    protected ?string $secretKey = null;
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

    /**
     * @throws CheckoutArgumentException
     */
    protected function validateSecretKey(string $key, string $secretKeyPattern): void
    {
        if ($this->validKey($secretKeyPattern, $key)) {
            return;
        }
        throw new CheckoutArgumentException("invalid secret key");
    }

    /**
     * @throws CheckoutArgumentException
     */
    protected function validatePublicKey(string $key, string $publicKeyPattern): void
    {
        if (empty($key)) {
            return;
        }
        if ($this->validKey($publicKeyPattern, $key)) {
            return;
        }
        throw new CheckoutArgumentException("invalid public key");
    }

    private function validKey(string $pattern, string $key): bool
    {
        return preg_match($pattern, $key);
    }

    protected abstract function getSdkCredentials(): SdkCredentialsInterface;

    protected abstract function setPublicKey(string $publicKey): void;

    protected abstract function setSecretKey(string $secretKey): void;

    /**
     * @return mixed
     */
    protected abstract function build();

}
