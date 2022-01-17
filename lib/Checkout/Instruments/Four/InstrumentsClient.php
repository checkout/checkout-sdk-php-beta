<?php

namespace Checkout\Instruments\Four;

use Checkout\ApiClient;
use Checkout\AuthorizationType;
use Checkout\CheckoutApiException;
use Checkout\CheckoutConfiguration;
use Checkout\Client;
use Checkout\Instruments\Four\Create\CreateInstrumentRequest;
use Checkout\Instruments\Four\Update\UpdateInstrumentRequest;

class InstrumentsClient extends Client
{
    private const INSTRUMENTS_PATH = "instruments";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKeyOrOAuth);
    }

    /**
     * @param CreateInstrumentRequest $createInstrumentRequest
     * @return mixed
     * @throws CheckoutApiException
     */
    public function create(CreateInstrumentRequest $createInstrumentRequest)
    {
        return $this->apiClient->post(self::INSTRUMENTS_PATH, $createInstrumentRequest, $this->sdkAuthorization());
    }

    /**
     * @param string $instrumentId
     * @return mixed
     * @throws CheckoutApiException
     */
    public function get(string $instrumentId)
    {
        return $this->apiClient->get($this->buildPath(self::INSTRUMENTS_PATH, $instrumentId), $this->sdkAuthorization());
    }

    /**
     * @param string $instrumentId
     * @param UpdateInstrumentRequest $updateInstrumentRequest
     * @return mixed
     * @throws CheckoutApiException
     */
    public function update(string $instrumentId, UpdateInstrumentRequest $updateInstrumentRequest)
    {
        return $this->apiClient->patch($this->buildPath(self::INSTRUMENTS_PATH, $instrumentId), $updateInstrumentRequest, $this->sdkAuthorization());
    }

    /**
     * @param string $instrumentId
     * @throws CheckoutApiException
     */
    public function delete(string $instrumentId): void
    {
        $this->apiClient->delete($this->buildPath(self::INSTRUMENTS_PATH, $instrumentId), $this->sdkAuthorization());
    }
}
