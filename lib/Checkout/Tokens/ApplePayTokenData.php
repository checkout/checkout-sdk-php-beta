<?php

namespace Checkout\Tokens;

final class ApplePayTokenData
{
    public string $version;

    public string $data;

    public string $signature;

    public array $header;
}
