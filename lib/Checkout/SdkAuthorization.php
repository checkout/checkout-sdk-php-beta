<?php

namespace Checkout;

final class SdkAuthorization
{
    private const BEARER = "Bearer ";

    private string $platformType;

    private string $credential;

    /**
     * @param mixed $platformType
     * @param mixed $credential
     */
    public function __construct($platformType, $credential)
    {
        $this->platformType = $platformType;
        $this->credential = $credential;
    }

    /**
     * @throws CheckoutAuthorizationException
     */
    public function getAuthorizationHeader(): string
    {
        if ($this->platformType == PlatformType::$default) {
            return $this->credential;
        }
        if ($this->platformType == PlatformType::$four) {
            return self::BEARER . $this->credential;
        }
        throw new CheckoutAuthorizationException("Invalid platform type");
    }
}
