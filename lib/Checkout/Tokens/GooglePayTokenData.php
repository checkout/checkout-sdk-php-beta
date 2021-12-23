<?php

namespace Checkout\Tokens;

final class GooglePayTokenData
{
    public string $signature;

    public string $protocolVersion;

    public string $signedMessage;
}
