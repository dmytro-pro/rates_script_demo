<?php

use DmytroPro\RatesScriptDemo\ExchangeRateProvider;
use PHPUnit\Framework\TestCase;
use phpmock\phpunit\PHPMock;


class ExchangeRateProviderTest extends TestCase
{
    public function testGetRate()
    {
        // Load the fixture data
        $fixture = file_get_contents(__DIR__ . '/fixtures/exchange_rates.json');

        // Mock HTTP client (just returns the fixture data)
        $mockHttpClient = function ($url) use ($fixture) {
            return $fixture;
        };

        // Inject the mock HTTP client into the provider
        $exchangeRateProvider = new ExchangeRateProvider('mocked_key', $mockHttpClient);

        // Perform the test
        $rate = $exchangeRateProvider->getRate('USD');

        // Assertions
        $this->assertEquals(1.109324, $rate);
    }
}
