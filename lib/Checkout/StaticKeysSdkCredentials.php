<?php

namespace Checkout;

class StaticKeysSdkCredentials implements SdkCredentialsInterface
{

    private string $publicKey;

    private string $secretKey;

    public function __construct(string $publicKey, string $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @throws CheckoutAuthorizationException
     */
    function getAuthorization(string $authorizationType): SdkAuthorization
    {
        switch ($authorizationType) {
            case AuthorizationType::$publicKey:
                return new SdkAuthorization(PlatformType::$default, $this->publicKey);
            case AuthorizationType::$secretKey:
                return new SdkAuthorization(PlatformType::$default, $this->secretKey);
            default:
                throw new CheckoutAuthorizationException("Operation does not support" . $authorizationType . "authorization type");
        }
    }
}
