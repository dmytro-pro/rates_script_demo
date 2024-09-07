<?php

use DmytroPro\RatesScriptDemo\BinlistProvider;
use DmytroPro\RatesScriptDemo\ExchangeRateProvider;
use DmytroPro\RatesScriptDemo\RateCalculator;

require 'vendor/autoload.php';

$apiKey = getenv('API_KEY_EXCHANGE_RATES_API');
if (!$apiKey) {
    throw new Exception('API_KEY_EXCHANGE_RATES_API is not set in the environment, see Readme.md');
}

$binProvider = new BinlistProvider();
$exchangeRateProvider = new ExchangeRateProvider($apiKey);
$rateCalculator = new RateCalculator($binProvider, $exchangeRateProvider);

if (!isset($argv[1])) {
    throw new Exception('No input file provided. Usage: php rates.php <file>');
}

$rateCalculator->calculateRatesFromFile($argv[1]);
