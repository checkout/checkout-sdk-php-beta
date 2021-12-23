<?php

namespace Checkout\Tokens;

final class ApplePayTokenRequest extends WalletTokenRequest
{
    function __construct()
    {
        parent::__construct(TokenType::$applepay);
    }

    public ApplePayTokenData $token_data;

}
