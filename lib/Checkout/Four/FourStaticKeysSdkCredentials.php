<?php

namespace Checkout\Four;

use Checkout\AuthorizationType;
use Checkout\CheckoutArgumentException;
use Checkout\CheckoutAuthorizationException;
use Checkout\PlatformType;
use Checkout\SdkAuthorization;

class FourStaticKeysSdkCredentials extends AbstractStaticKeysSdkCredentials
{

    private const SECRET_KEY_PATTERN = "/^sk_(sbox_)?[a-z2-7]{26}[a-z2-7*#$=]$/";
    private const PUBLIC_KEY_PATTERN = "/^pk_(sbox_)?[a-z2-7]{26}[a-z2-7*#$=]$/";

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
                return new SdkAuthorization(PlatformType::$four, $this->publicKey);
            case AuthorizationType::$secretKey:
                if (empty($this->secretKey)) {
                    throw new CheckoutAuthorizationException("secret key is required for this operation");
                }
                return new SdkAuthorization(PlatformType::$four, $this->secretKey);
            default:
                throw new CheckoutAuthorizationException("Operation does not support" . $authorizationType . "authorization type");
        }
    }
}
