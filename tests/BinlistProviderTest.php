<?php

use DmytroPro\RatesScriptDemo\BinlistProvider;
use PHPUnit\Framework\TestCase;
use phpmock\phpunit\PHPMock;


class BinlistProviderTest extends TestCase
{
    public function testGetBinData()
    {
        // Load the fixture data
        $fixture = file_get_contents(__DIR__ . '/fixtures/bin_45717360.json');

        // Mock HTTP client (just returns the fixture data)
        $mockHttpClient = function ($url) use ($fixture) {
            return $fixture;
        };

        // Inject the mock HTTP client into the provider
        $binlistProvider = new BinlistProvider($mockHttpClient);

        // Perform the test
        $binData = $binlistProvider->getBinData('45717360');

        // Assertions
        $this->assertEquals('DK', $binData->country->alpha2);
        $this->assertEquals('Jyske Bank A/S', $binData->bank->name);
    }
}
