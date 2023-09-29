<?php

declare(strict_types=1);

namespace PageSpeed\Insights;

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
    public function getResults(string $url, string $strategy, array $extraParams = []): array
    {
        $categories = '';
        if(isset($extraParams['category'])){
            foreach ($extraParams['category'] as $category_id){
                $categories .= '&category='.$category_id;
            }
            unset($extraParams['category']);
        }

        $params = array_merge([
            'locale' => $this->locales,
            'key' => $this->apiKey,
            'url' => $url,
            'strategy' => $strategy
        ], $extraParams);

        $response = $this->client->request(
            'GET',
            $this->apiUrl . '?' . http_build_query($params) . $categories,
            ['timeout' => $this->timeout]
        );

        return $response->toArray();
    }
}