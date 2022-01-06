<?php

namespace Checkout\Four;

use Checkout\CheckoutArgumentException;
use Checkout\SdkCredentialsInterface;

abstract class AbstractStaticKeysSdkCredentials implements SdkCredentialsInterface
{
    protected ?string $publicKey;

    protected string $secretKey;

    /**
     * @param string|null $publicKey
     * @param string $secretKey
     */
    public function __construct(string $secretKey, ?string $publicKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @throws CheckoutArgumentException
     */
    protected function validateSecretKey(string $secretKeyPattern): void
    {
        if ($this->validKey($secretKeyPattern, $this->secretKey)) {
            return;
        }
        throw new CheckoutArgumentException("invalid secret key");
    }

    /**
     * @throws CheckoutArgumentException
     */
    protected function validatePublicKey(string $publicKeyPattern): void
    {
        if (empty($this->publicKey)) {
            return;
        }
        if ($this->validKey($publicKeyPattern, $this->publicKey)) {
            return;
        }
        throw new CheckoutArgumentException("invalid public key");
    }

    private function validKey(string $pattern, string $key): bool
    {
        return preg_match($pattern, $key);
    }

}
