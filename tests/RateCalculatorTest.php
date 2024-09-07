<?php

use DmytroPro\RatesScriptDemo\BinlistProvider;
use DmytroPro\RatesScriptDemo\ExchangeRateProvider;
use DmytroPro\RatesScriptDemo\RateCalculator;
use PHPUnit\Framework\TestCase;

class RateCalculatorTest extends TestCase
{
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

        // Capture the output
        ob_start();
        $rateCalculator->calculateRatesFromFile($inputFile);
        $output = ob_get_clean();

        // Clean up the temporary file
        unlink($inputFile);

        // Convert the output to a float for comparison
        $output = floatval(trim($output));

        // Expected result
        $expected = 100 / 1.109324 * 0.01;

        // Assert the result with a precision of 8 decimal places
        $this->assertEqualsWithDelta($expected, $output, 0.00000001);
    }
}
