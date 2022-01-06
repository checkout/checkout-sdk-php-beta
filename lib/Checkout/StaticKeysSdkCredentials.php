<?php

namespace Checkout;

use Checkout\Four\AbstractStaticKeysSdkCredentials;

class StaticKeysSdkCredentials extends AbstractStaticKeysSdkCredentials
{
    private const SECRET_KEY_PATTERN = "/^sk_(test_)?(\\w{8})-(\\w{4})-(\\w{4})-(\\w{4})-(\\w{12})$/";
    private const PUBLIC_KEY_PATTERN = "/^pk_(test_)?(\\w{8})-(\\w{4})-(\\w{4})-(\\w{4})-(\\w{12})$/";

    /**
     * @param string $secretKey
     * @param string|null $publicKey
     * @throws CheckoutArgumentException
     */
    public function __construct(string $secretKey, ?string $publicKey)
    {
        parent::__construct($secretKey, $publicKey);
        $this->validateSecretKey(self::SECRET_KEY_PATTERN);
        $this->validatePublicKey(self::PUBLIC_KEY_PATTERN);
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
