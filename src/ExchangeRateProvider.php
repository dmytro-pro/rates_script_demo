<?php

namespace DmytroPro\RatesScriptDemo;

class ExchangeRateProvider implements ExchangeRateProviderInterface
{
    private $httpClient;
    private string $apiKey;

    private $cache = [];

    public function __construct($apiKey, callable $httpClient = null)
    {
        $this->apiKey = $apiKey;
        // Use file_get_contents by default if no HTTP client is passed
        $this->httpClient = $httpClient ?: function ($url) {
            return file_get_contents($url);
        };
    }

    public function getRate($currency)
    {
        if (!$this->cache) {
            $url = 'https://api.exchangeratesapi.io/latest?access_key=' . $this->apiKey;
            $response = call_user_func($this->httpClient, $url);
            if (!$response) {
                throw new \Exception("Error fetching exchange rates.");
            }
            $this->cache = json_decode($response, true);
        }

        return $this->cache['rates'][$currency] ?? 0;
    }
}
