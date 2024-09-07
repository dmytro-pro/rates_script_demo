<?php

namespace DmytroPro\RatesScriptDemo;

class BinlistProvider
{
    private $baseUrl = 'https://lookup.binlist.net/';

    public function getBinData($bin)
    {
        $response = file_get_contents($this->baseUrl . $bin);
        if (!$response) {
            throw new Exception("Error fetching BIN data.");
        }
        return json_decode($response);
    }
}