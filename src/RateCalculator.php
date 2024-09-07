<?php

namespace DmytroPro\RatesScriptDemo;

class RateCalculator
{
    // todo: CURRENCY_EUR, and others.

    private $binProvider;
    private $exchangeRateProvider;

    public function __construct(BinlistProvider $binProvider, ExchangeRateProvider $exchangeRateProvider)
    {
        $this->binProvider = $binProvider;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    public function calculateRatesFromFile(string $filePath)
    {
        $rows = explode("\n", file_get_contents($filePath));
        foreach ($rows as $row) {
            if (empty($row)) {
                continue;
            }

            $data = json_decode($row, true);
            $bin = $data['bin'];
            $amount = $data['amount'];
            $currency = $data['currency'];

            $binData = $this->binProvider->getBinData($bin);
            $isEu = $this->isEu($binData->country->alpha2);

            $rate = $currency === 'EUR' ? 1 : $this->exchangeRateProvider->getRate($currency);
            $amntFixed = ($currency === 'EUR' || $rate == 0) ? $amount : $amount / $rate;

            echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
            echo "\n";
        }
    }

    private function isEu(string $countryCode): string
    {
        $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
        return in_array($countryCode, $euCountries) ? 'yes' : 'no';
    }
}
