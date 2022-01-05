<?php

namespace Checkout\Four;

use Checkout\ApiClient;
use Checkout\CheckoutConfiguration;
use Checkout\Tokens\TokensClient;

final class CheckoutApi
{
    private TokensClient $tokensClient;

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        $this->tokensClient = new TokensClient($apiClient, $configuration);
    }

    public function getTokensClient(): TokensClient
    {
        return $this->tokensClient;
    }
}
