<?php

namespace Checkout\Four;

use Checkout\AbstractCheckoutSdkBuilder;
use Checkout\ApiClient;
use Checkout\CheckoutArgumentException;
use Checkout\CheckoutConfiguration;
use Checkout\SdkCredentialsInterface;
use Checkout\StaticKeysSdkCredentials;

class FourStaticKeysCheckoutSdkBuilder extends AbstractCheckoutSdkBuilder
{
    private const SECRET_KEY_PATTERN = "/^sk_(sbox_)?[a-z2-7]{26}[a-z2-7*#$=]$/";
    private const PUBLIC_KEY_PATTERN = "/^pk_(sbox_)?[a-z2-7]{26}[a-z2-7*#$=]$/";

    private ?string $publicKey;

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
        return new StaticKeysSdkCredentials(self::SECRET_KEY_PATTERN, self::PUBLIC_KEY_PATTERN,
            $this->secretKey, $this->publicKey);
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
