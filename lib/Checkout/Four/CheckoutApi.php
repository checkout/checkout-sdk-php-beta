<?php

namespace Checkout\Four;

use Checkout\ApiClient;
use Checkout\CheckoutConfiguration;
use Checkout\Customers\Four\CustomersClient;
use Checkout\Disputes\DisputesClient;
use Checkout\Forex\ForexClient;
use Checkout\Instruments\Four\InstrumentsClient;
use Checkout\Payments\Four\PaymentsClient;
use Checkout\Tokens\TokensClient;

final class CheckoutApi
{
    private TokensClient $tokensClient;
    private CustomersClient $customersClient;
    private PaymentsClient $paymentsClient;
    private InstrumentsClient $instrumentsClient;
    private ForexClient $forexClient;
    private DisputesClient $disputesClient;

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        $this->tokensClient = new TokensClient($apiClient, $configuration);
        $this->customersClient = new CustomersClient($apiClient, $configuration);
        $this->paymentsClient = new PaymentsClient($apiClient, $configuration);
        $this->instrumentsClient = new InstrumentsClient($apiClient, $configuration);
        $this->forexClient = new ForexClient($apiClient, $configuration);
        $this->disputesClient = new DisputesClient($apiClient, $configuration);
    }

    public function getTokensClient(): TokensClient
    {
        return $this->tokensClient;
    }

    public function getCustomersClient(): CustomersClient
    {
        return $this->customersClient;
    }

    public function getPaymentsClient(): PaymentsClient
    {
        return $this->paymentsClient;
    }

    public function getInstrumentsClient(): InstrumentsClient
    {
        return $this->instrumentsClient;
    }

    public function getForexClient(): ForexClient
    {
        return $this->forexClient;
    }

    public function getDisputesClient(): DisputesClient
    {
        return $this->disputesClient;
    }

}
