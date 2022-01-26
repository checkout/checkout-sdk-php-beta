<?php

namespace Checkout;

use Checkout\Common\AbstractQueryFilter;
use Checkout\Files\FileRequest;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ApiClient
{

    private CheckoutConfiguration $configuration;

    private ClientInterface $client;

    private JsonSerializer $jsonSerializer;

    private LoggerInterface $logger;

    /**
     * @param CheckoutConfiguration $configuration
     */
    public function __construct(CheckoutConfiguration $configuration)
    {
        $this->configuration = $configuration;
        $this->client = $configuration->getHttpClientBuilder()->getClient();
        $this->jsonSerializer = new JsonSerializer();
        $this->logger = $this->configuration->getLogger();
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
        return $this->jsonSerializer->deserialize($response->getBody());
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
        $response = $this->invoke("POST", $path, is_null($body) ? $body : $this->jsonSerializer->serialize($body), $authorization, $idempotencyKey);

        return $this->jsonSerializer->deserialize($response->getBody());
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
        $response = $this->invoke("PUT", $path, $this->jsonSerializer->serialize($body), $authorization);
        return $this->jsonSerializer->deserialize($response->getBody());
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
        $response = $this->invoke("PATCH", $path, $this->jsonSerializer->serialize($body), $authorization);
        return $this->jsonSerializer->deserialize($response->getBody());
    }

    /**
     * @param string $path
     * @param SdkAuthorization $authorization
     * @throws CheckoutApiException
     */
    public function delete(string $path, SdkAuthorization $authorization): void
    {
        $this->invoke("DELETE", $path, null, $authorization);
    }

    /**
     * @param string $path
     * @param AbstractQueryFilter $body
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function query(string $path, AbstractQueryFilter $body, SdkAuthorization $authorization)
    {
        $this->logger->info("GET " . $path);
        $queryParameters = $body->getEncodedQueryParameters();
        if (!empty($queryParameters)) {
            $path .= "?" . $queryParameters;
        }
        $response = $this->invoke("GET", $path, null, $authorization);
        return $this->jsonSerializer->deserialize($response->getBody());
    }

    /**
     * @param string $path
     * @param FileRequest $fileRequest
     * @param SdkAuthorization $authorization
     * @return mixed
     * @throws CheckoutApiException
     */
    public function submitFile(string $path, FileRequest $fileRequest, SdkAuthorization $authorization)
    {
        try {
            $this->logger->info("POST " . $path . " file: " . $fileRequest->file);
            $headers = $this->getHeaders($authorization, null, null);
            $response = $this->client->request("POST", $this->getRequestUrl($path), [
                "verify" => false,
                "headers" => $headers,
                "multipart" => [
                    [
                        "name" => "file",
                        "contents" => fopen($fileRequest->file, "r")
                    ],
                    [
                        "name" => "purpose",
                        "contents" => $fileRequest->purpose
                    ]
                ]]);
            return json_decode($response->getBody(), true);
        } catch (Throwable $e) {
            $this->logger->error($path . " error: " . $e->getMessage());
            if ($e instanceof ClientException) {
                throw new CheckoutApiException("The API response status code (" . $e->getCode() . ") does not indicate success.");
            }
            throw new CheckoutApiException($e);
        }
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
            $this->logger->info($method . " " . $path);
            $headers = $this->getHeaders($authorization, "application/json", $idempotencyKey);
            return $this->client->request($method, $this->getRequestUrl($path), [
                "verify" => false,
                "body" => $body,
                "headers" => $headers
            ]);
        } catch (Throwable $e) {
            $this->logger->error($path . " error: " . $e->getMessage());
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


    /**
     * @param SdkAuthorization $authorization
     * @param string|null $contentType
     * @param string|null $idempotencyKey
     * @return array
     * @throws CheckoutAuthorizationException
     */
    private function getHeaders(SdkAuthorization $authorization, ?string $contentType, ?string $idempotencyKey): array
    {
        $headers = [
            "User-agent" => CheckoutUtils::PROJECT_NAME . "/" . CheckoutUtils::PROJECT_VERSION,
            "Accept" => "application/json",
            "Authorization" => $authorization->getAuthorizationHeader()
        ];
        if (!empty($contentType)) {
            $headers["Content-Type"] = $contentType;
        }
        if (!empty($idempotencyKey)) {
            $headers["Cko-Idempotency-Key"] = $idempotencyKey;
        }
        return $headers;
    }

}
