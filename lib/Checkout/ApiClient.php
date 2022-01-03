<?php

namespace Checkout;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiClient
{
    private CheckoutConfiguration $configuration;

    private ClientInterface $client;

    public function __construct(CheckoutConfiguration $configuration)
    {
        $this->configuration = $configuration;
        $this->client = $configuration->getHttpClientBuilder()->getClient();
    }

    /**
     * @param string $path
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function get(string $path, SdkAuthorization $authorization)
    {
        $response = $this->invoke("GET", $path, null, $authorization);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $path
     * @param mixed $body
     * @param SdkAuthorization $authorization
     * @param string|null $idempotencyKey
     * @return mixed
     * @throws CheckoutApiException
     */
    public function post(string $path, $body, SdkAuthorization $authorization, string $idempotencyKey = null)
    {
        $response = $this->invoke("POST", $path, json_encode($body), $authorization, $idempotencyKey);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $path
     * @param mixed $body
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function put(string $path, $body, SdkAuthorization $authorization)
    {
        $response = $this->invoke("PUT", $path, json_encode($body), $authorization);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $path
     * @param mixed $body
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function patch(string $path, $body, SdkAuthorization $authorization)
    {
        $response = $this->invoke("PATCH", $path, json_encode($body), $authorization);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $path
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function delete(string $path, SdkAuthorization $authorization)
    {
        $response = $this->invoke("DELETE", $path, null, $authorization);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $path
     * @param mixed $body
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function query(string $path, $body, SdkAuthorization $authorization)
    {
        if (!is_null($body)) {
            $query = http_build_query($body);
            if (empty($body)) {
                $path = $path . "?" . $query;
            }
        }
        $response = $this->invoke("GET", $path, null, $authorization);
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $method
     * @param string $path
     * @param string|null $body
     * @param SdkAuthorization $authorization
     * @param string|null $idempotencyKey
     * @return ResponseInterface
     * @throws CheckoutApiException
     */
    private function invoke(string $method, string $path, ?string $body, SdkAuthorization $authorization, string $idempotencyKey = null): ResponseInterface
    {
        try {
            $headers = [
                "User-agent" => "checkout-sdk-php-beta/2.0.0",
                "Content-Type" => "application/json",
                "Accept" => "application/json",
                "Authorization" => $authorization->getAuthorizationHeader()
            ];
            if ($idempotencyKey) {
                $headers["Cko-Idempotency-Key"] = $idempotencyKey;
            }
            return $this->client->request($method, $this->getRequestUrl($path), [
                "verify" => false,
                "body" => $body,
                "headers" => $headers
            ]);
        } catch (Throwable $e) {
            if ($e instanceof ClientException) {
                throw new CheckoutApiException("The API response status code (" . $e->getCode() . ") does not indicate success.");
            }
            throw new CheckoutApiException($e);
        }
    }

    private function getRequestUrl(string $path): string
    {
        return $this->configuration->getEnvironment()->getBaseUri() . $path;
    }

}
