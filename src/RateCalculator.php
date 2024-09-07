<?php

namespace DmytroPro\RatesScriptDemo;

class RateCalculator
{
    private const CURRENCY_EUR = 'EUR';

    private $binProvider;
    private $exchangeRateProvider;
    private $euCountries = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR',
        'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

    public function __construct(BinlistProvider $binProvider, ExchangeRateProvider $exchangeRateProvider)
    {
        $this->binProvider = $binProvider;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    /**
     * @param string $filePath
     * @return void
     * @throws \Exception
     */
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

            // Use a constant for EUR comparison
            $rate = $currency === self::CURRENCY_EUR ? 1 : $this->exchangeRateProvider->getRate($currency);
            $amountFixed = ($currency === self::CURRENCY_EUR || $rate == 0) ? $amount : $amount / $rate;

            // Apply commission rate and ceiling the result to the nearest cent
            $commission = $amountFixed * ($isEu ? 0.01 : 0.02);
            $commission = ceil($commission * 100) / 100; // Ceiling to the nearest cent

            echo $commission;
            echo "\n";
        }
    }

    private function isEu(string $countryCode): bool
    {
        return in_array($countryCode, $this->euCountries);
    }
}
