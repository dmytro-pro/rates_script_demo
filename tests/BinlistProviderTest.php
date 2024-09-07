<?php

use DmytroPro\RatesScriptDemo\BinlistProvider;
use PHPUnit\Framework\TestCase;

class BinlistProviderTest extends TestCase
{
    public function testGetBinData()
    {
        $binlistProvider = new BinlistProvider();
        $binData = $binlistProvider->getBinData('45717360');

        $this->assertEquals('DK', $binData->country->alpha2);
        $this->assertEquals('Jyske Bank A/S', $binData->bank->name);
    }
}