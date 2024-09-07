<?php

namespace DmytroPro\RatesScriptDemo;

class BinlistProvider
{
    private $httpClient;

    private $cache = [];

    public function __construct(callable $httpClient = null)
    {
        // Use file_get_contents by default if no HTTP client is passed
        $this->httpClient = $httpClient ?: function ($url) {
            return file_get_contents($url);
        };
    }

    public function getBinData($binId)
    {
        if (isset($this->cache[$binId])) {
            return $this->cache[$binId];
        }
        $url = 'https://lookup.binlist.net/' . $binId;
        $response = call_user_func($this->httpClient, $url);
        if (!$response) {
            throw new \Exception("Error fetching BIN data.");
        }
        $this->cache[$binId] = json_decode($response);

        return $this->cache[$binId];
    }
}
