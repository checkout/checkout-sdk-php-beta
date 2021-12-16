<?php

namespace Checkout\Instruments;

use Checkout\ApiClient;
use Checkout\AuthorizationType;
use Checkout\CheckoutConfiguration;
use Checkout\Client;

class InstrumentsClient extends Client
{
    const INSTRUMENTS_PATH = "instruments";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKey);
    }

    /**
     * @param CreateInstrumentRequest $createInstrumentRequest
     * @return mixed
     */
    public function create(CreateInstrumentRequest $createInstrumentRequest)
    {
        return $this->apiClient->post(self::INSTRUMENTS_PATH, $createInstrumentRequest, $this->sdkAuthorization());
    }

    /**
     * @param string $instrumentId
     * @return mixed
     */
    public function get(string $instrumentId)
    {
        return $this->apiClient->get($this->buildPath(self::INSTRUMENTS_PATH, $instrumentId), $this->sdkAuthorization());
    }

    /**
     * @param string $instrumentId
     * @param UpdateInstrumentRequest $updateInstrumentRequest
     * @return mixed
     */
    public function update(string $instrumentId, UpdateInstrumentRequest $updateInstrumentRequest)
    {
        return $this->apiClient->patch($this->buildPath(self::INSTRUMENTS_PATH, $instrumentId), $updateInstrumentRequest, $this->sdkAuthorization());
    }

    /**
     * @param string $instrumentId
     * @return mixed
     */
    public function delete(string $instrumentId)
    {
        return $this->apiClient->delete($this->buildPath(self::INSTRUMENTS_PATH, $instrumentId), $this->sdkAuthorization());
    }

}
