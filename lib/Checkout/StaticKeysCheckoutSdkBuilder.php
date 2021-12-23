<?php

namespace Checkout;

class StaticKeysCheckoutSdkBuilder extends AbstractCheckoutSdkBuilder
{

    private string $publicKey;

    private string $secretKey;

    public function setPublicKey(string $publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    protected function getSdkCredentials(): SdkCredentialsInterface
    {
        return new StaticKeysSdkCredentials($this->publicKey, $this->secretKey);
    }

    public function build(): CheckoutApi
    {
        $configuration = new CheckoutConfiguration($this->getSdkCredentials(), $this->environment, $this->httpClientBuilder);
        $apiClient = new ApiClient($configuration);
        return new CheckoutApi($apiClient, $configuration);
    }
}
