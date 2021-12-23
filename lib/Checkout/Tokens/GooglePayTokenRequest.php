<?php

namespace Checkout\Tokens;

final class GooglePayTokenRequest extends WalletTokenRequest
{
    function __construct()
    {
        parent::__construct(TokenType::$googlepay);
    }

    public GooglePayTokenData $token_data;

}
