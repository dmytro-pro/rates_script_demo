<?php

use DmytroPro\RatesScriptDemo\BinlistProvider;
use DmytroPro\RatesScriptDemo\CeilRateRenderer;
use DmytroPro\RatesScriptDemo\ExchangeRateProvider;
use DmytroPro\RatesScriptDemo\RateCalculator;

require 'vendor/autoload.php';

$apiKey = getenv('API_KEY_EXCHANGE_RATES_API');
if (!$apiKey) {
    throw new Exception('API_KEY_EXCHANGE_RATES_API is not set in the environment.');
}

$binProvider = new BinlistProvider();
$exchangeRateProvider = new ExchangeRateProvider($apiKey);
$rateCalculator = new RateCalculator($binProvider, $exchangeRateProvider);
$renderer = new CeilRateRenderer();

$inputFile = $argv[1];
if (!isset($inputFile)) {
    throw new Exception('No input file provided. Usage: php rates.php <file>');
}

$iterator = $rateCalculator->getRatesFromFileIterator($inputFile);
foreach ($iterator as $commission) {
    echo $renderer->render($commission) . "\n";
}
