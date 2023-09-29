<?php

declare(strict_types=1);


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Service
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrl,
        private readonly string $apiKey,
        private string $locales = 'fr_Fr',
        private int $timeout = 300
    )
    {
    }

    public function setLocales(string $locales): static
    {
        $this->locales = $locales;

        return $this;
    }

    public function setTimeout(int $timeout): static
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getResults(string $url, string $strategy, array $extraParams = []): array
    {
        $params = array_merge([
            'locale' => $this->locales,
            'key' => $this->apiKey,
            'url' => $url,
            'strategy' => $strategy
        ], $extraParams);

        $response = $this->client->request('GET', $this->apiUrl, [
            'query' => $params,
            'timeout' => $this->timeout
        ]);

        return $response->toArray();
    }
}