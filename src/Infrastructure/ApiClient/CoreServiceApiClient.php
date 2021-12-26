<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\ApiClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class CoreServiceApiClient
{
    public const BASE_ENDPOINT = '/repositories/%s';

    public function __construct(
        protected Client $httpClient,
        protected string $baseUrl
    ) {
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param string|null $body
     * @param array $options
     * @return array|null
     * @throws CoreServiceException
     */
    protected function request(string $method, string $endpoint, string $body = null, array $options = []): ?array
    {
        $options = array_merge(['body' => $body], $options);

        try {
            $response = $this->httpClient->request($method, $endpoint, $options);
            $responseContents = json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $exception) {
            if ($exception->getCode() == Response::HTTP_NOT_FOUND) {
                return [];
            }
            throw new CoreServiceException(
                sprintf(
                    "Core service request returned with an unexpected response: %s",
                    $exception->getMessage()
                )
            );
        } catch (GuzzleException|Exception $exception) {
            throw new CoreServiceException(
                sprintf(
                    "Core service request returned with an unexpected response: %s",
                    $exception->getMessage()
                )
            );
        }
        return $responseContents;
    }

}