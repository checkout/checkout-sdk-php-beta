<?php

namespace Checkout\Four;

use Checkout\ApiClient;
use Checkout\CheckoutConfiguration;
use Checkout\Customers\Four\CustomersClient;
use Checkout\Tokens\TokensClient;

final class CheckoutApi
{
    private TokensClient $tokensClient;
    private CustomersClient $customersClient;

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        $this->tokensClient = new TokensClient($apiClient, $configuration);
        $this->customersClient = new CustomersClient($apiClient, $configuration);
    }

    public function getTokensClient(): TokensClient
    {
        return $this->tokensClient;
    }

    public function getCustomersClient(): CustomersClient
    {
        return $this->customersClient;
    }
}
