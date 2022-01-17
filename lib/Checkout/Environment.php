<?php

namespace Checkout;

final class Environment
{
    private string $baseUri;
    private string $authorizationUri;
    private bool $isSandbox;

    private function __construct(string $baseUri, string $authorizationUri, ?bool $isSandbox = true)
    {
        $this->authorizationUri = $authorizationUri;
        $this->baseUri = $baseUri;
        $this->isSandbox = $isSandbox;
    }

    public static function sandbox(): Environment
    {
        return new Environment("https://api.sandbox.checkout.com/", "https://access.sandbox.checkout.com/connect/token", true);
    }

    public static function production(): Environment
    {

        return new Environment("https://api.checkout.com/", "https://access.checkout.com/connect/token", false);

    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getAuthorizationUri(): string
    {
        return $this->authorizationUri;
    }

    public function isSandbox(): bool
    {
        return $this->isSandbox;
    }

}
