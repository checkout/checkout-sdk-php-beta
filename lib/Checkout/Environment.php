<?php

namespace Checkout;

final class Environment
{
    private string $baseUri;

    private function __construct(string $baseUri)
    {
        $this->baseUri = $baseUri;
    }

    public static function sandbox(): Environment
    {
        return new Environment("https://api.sandbox.checkout.com/");
    }

    public static function production(): Environment
    {
        return new Environment("https://api.checkout.com/");

    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

}
