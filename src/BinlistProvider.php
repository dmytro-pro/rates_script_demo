<?php

namespace DmytroPro\RatesScriptDemo;

class BinlistProvider
{
    private $httpClient;

    public function __construct(callable $httpClient = null)
    {
        // Use file_get_contents by default if no HTTP client is passed
        $this->httpClient = $httpClient ?: function ($url) {
            return file_get_contents($url);
        };
    }

    public function getBinData($bin)
    {
        $url = 'https://lookup.binlist.net/' . $bin;
        $response = call_user_func($this->httpClient, $url);
        if (!$response) {
            throw new \Exception("Error fetching BIN data.");
        }
        return json_decode($response);
    }
}
