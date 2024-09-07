<?php

namespace DmytroPro\RatesScriptDemo;

class ExchangeRateProvider
{
    private $baseUrl = 'https://api.exchangeratesapi.io/latest';
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getRate($currency)
    {
        $url = $this->baseUrl . '?access_key=' . $this->apiKey;
        $response = file_get_contents($url);
        if (!$response) {
            throw new \Exception("Error fetching exchange rates.");
        }
        $data = json_decode($response, true);
        return $data['rates'][$currency] ?? 0;
    }
}
