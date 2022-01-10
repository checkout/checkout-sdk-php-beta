<?php

namespace Checkout;

final class Environment
{
    private string $baseUri;

    private bool $isSandbox;

    private function __construct(string $baseUri, ?bool $isSandbox = true)
    {
        $this->isSandbox = $isSandbox;
        $this->baseUri = $baseUri;
    }

    public static function sandbox(): Environment
    {
        return new Environment("https://api.sandbox.checkout.com/");
    }

    public static function production(): Environment
    {

        return new Environment("https://api.checkout.com/", false);

    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function isSandbox(): bool
    {
        return $this->isSandbox;
    }

}
