<?php

use DmytroPro\RatesScriptDemo\ExchangeRateProvider;
use PHPUnit\Framework\TestCase;

class ExchangeRateProviderTest extends TestCase
{
    public function testGetRate()
    {
        var_dump(getenv('API_KEY_EXCHANGE_RATES_API'));
        $exchangeRateProvider = new ExchangeRateProvider(getenv('API_KEY_EXCHANGE_RATES_API'));
        $rate = $exchangeRateProvider->getRate('USD');

        $this->assertEquals(1.109324, $rate);
    }
}