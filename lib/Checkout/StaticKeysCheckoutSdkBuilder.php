<?php

namespace Checkout;

class StaticKeysCheckoutSdkBuilder extends AbstractCheckoutSdkBuilder
{

    private ?string $publicKey = null;

    private string $secretKey;

    public function setPublicKey(string $publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return SdkCredentialsInterface
     * @throws CheckoutArgumentException
     */
    protected function getSdkCredentials(): SdkCredentialsInterface
    {
        return new StaticKeysSdkCredentials($this->secretKey, $this->publicKey);
    }

    /**
     * @return CheckoutApi
     * @throws CheckoutArgumentException
     */
    public function build(): CheckoutApi
    {
        $configuration = new CheckoutConfiguration($this->getSdkCredentials(), $this->environment, $this->httpClientBuilder);
        $apiClient = new ApiClient($configuration);
        return new CheckoutApi($apiClient, $configuration);
    }
}
