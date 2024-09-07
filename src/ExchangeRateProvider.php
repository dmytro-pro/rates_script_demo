<?php

namespace DmytroPro\RatesScriptDemo;

class ExchangeRateProvider
{
    private $httpClient;
    private string $apiKey;

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
        $url = 'https://api.exchangeratesapi.io/latest?access_key=' . $this->apiKey;
        $response = call_user_func($this->httpClient, $url);
        if (!$response) {
            throw new \Exception("Error fetching exchange rates.");
        }
        $data = json_decode($response, true);
        return $data['rates'][$currency] ?? 0;
    }
}

