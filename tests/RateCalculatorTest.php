<?php

use DmytroPro\RatesScriptDemo\BinlistProvider;
use DmytroPro\RatesScriptDemo\ExchangeRateProvider;
use DmytroPro\RatesScriptDemo\RateCalculator;
use DmytroPro\RatesScriptDemo\RendererInterface;
use PHPUnit\Framework\TestCase;

class RateCalculatorTest extends TestCase
{
    public function testCalculateCommission()
    {
        // Mock the bin provider
        $binFixture = file_get_contents(__DIR__ . '/fixtures/bin_45717360.json');
        $mockBinProvider = $this->createMock(BinlistProvider::class);
        $mockBinProvider->method('getBinData')->willReturn(json_decode($binFixture));

        // Mock the exchange rate provider
        $rateFixture = file_get_contents(__DIR__ . '/fixtures/exchange_rates.json');
        $mockExchangeRateProvider = $this->createMock(ExchangeRateProvider::class);
        $mockExchangeRateProvider->method('getRate')->willReturn(json_decode($rateFixture, true)['rates']['USD']);

        // Create the RateCalculator instance with the mocks
        $rateCalculator = new RateCalculator($mockBinProvider, $mockExchangeRateProvider);

        // Input data
        $inputData = [
            'bin' => '45717360',
            'amount' => 100.00,
            'currency' => 'USD'
        ];

        // Expected result
        $expectedCommission = 100 / 1.109324 * 0.01;

        // Assert the result from calculateCommission
        $this->assertEquals($expectedCommission, $rateCalculator->calculateCommission($inputData));
    }

    public function testCalculateRatesFromFile()
    {
        // Mock the bin provider
        $binFixture = file_get_contents(__DIR__ . '/fixtures/bin_45717360.json');
        $mockBinProvider = $this->createMock(BinlistProvider::class);
        $mockBinProvider->method('getBinData')->willReturn(json_decode($binFixture));

        // Mock the exchange rate provider
        $rateFixture = file_get_contents(__DIR__ . '/fixtures/exchange_rates.json');
        $mockExchangeRateProvider = $this->createMock(ExchangeRateProvider::class);
        $mockExchangeRateProvider->method('getRate')->willReturn(json_decode($rateFixture, true)['rates']['USD']);

        // Create the RateCalculator instance with the mocks
        $rateCalculator = new RateCalculator($mockBinProvider, $mockExchangeRateProvider);

        // Create a temporary input file
        $inputData = '{"bin":"45717360","amount":"100.00","currency":"USD"}' . PHP_EOL;
        $inputFile = tempnam(sys_get_temp_dir(), 'input');
        file_put_contents($inputFile, $inputData);

        // Test the generator
        $generator = $rateCalculator->getRatesFromFileGenerator($inputFile);
        $commission = $generator->current();  // Get the first yielded commission

        // Clean up the temporary file
        unlink($inputFile);

        // Assert the generated commission is correct
        $expectedCommission = 100 / 1.109324 * 0.01;
        $this->assertEquals($expectedCommission, $commission);
    }
}