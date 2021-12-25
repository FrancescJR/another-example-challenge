<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\ApiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

class CoreServiceApiClient
{
    public const BASE_ENDPOINT = '/repositories/%repositoryId/';

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
        } catch (GuzzleException|Exception $exception) {
            throw new CoreServiceException("Core service request returned with an unexpected response");
        }
        return $responseContents;
    }

}