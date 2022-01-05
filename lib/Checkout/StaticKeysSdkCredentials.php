<?php

namespace Checkout;

class StaticKeysSdkCredentials implements SdkCredentialsInterface
{

    private ?string $publicKey;

    private string $secretKey;

    private string $publicKeyPattern;

    private string $secretKeyPattern;

    /**
     * @param string $secretKeyPattern
     * @param string $publicKeyPattern
     * @param string $secretKey
     * @param string|null $publicKey
     * @throws CheckoutArgumentException
     */
    public function __construct(string $secretKeyPattern, string $publicKeyPattern, string $secretKey, ?string $publicKey)
    {
        $this->secretKeyPattern = $secretKeyPattern;
        $this->publicKeyPattern = $publicKeyPattern;
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
        $this->validateSecretKey();
        $this->validatePublicKey();
    }

    /**
     * @throws CheckoutArgumentException
     */
    private function validateSecretKey(): void
    {
        if ($this->validKey($this->secretKeyPattern, $this->secretKey)) {
            return;
        }
        throw new CheckoutArgumentException("invalid secret key");
    }

    /**
     * @throws CheckoutArgumentException
     */
    private function validatePublicKey(): void
    {
        if (empty($this->publicKey)) {
            return;
        }
        if ($this->validKey($this->publicKeyPattern, $this->publicKey)) {
            return;
        }
        throw new CheckoutArgumentException("invalid public key");
    }

    private function validKey(string $pattern, string $key): bool
    {
        return preg_match($pattern, $key);
    }

    /**
     * @throws CheckoutAuthorizationException
     */
    function getAuthorization(string $authorizationType): SdkAuthorization
    {
        switch ($authorizationType) {
            case AuthorizationType::$publicKey:
                if (empty($this->publicKey)) {
                    throw new CheckoutAuthorizationException("public key is required for this operation");
                }
                return new SdkAuthorization(PlatformType::$default, $this->publicKey);
            case AuthorizationType::$secretKey:
                if (empty($this->secretKey)) {
                    throw new CheckoutAuthorizationException("secret key is required for this operation");
                }
                return new SdkAuthorization(PlatformType::$default, $this->secretKey);
            default:
                throw new CheckoutAuthorizationException("Operation does not support" . $authorizationType . "authorization type");
        }
    }
}
