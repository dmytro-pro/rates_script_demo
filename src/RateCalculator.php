<?php

namespace DmytroPro\RatesScriptDemo;

class RateCalculator
{
    private $binProvider;
    private $exchangeRateProvider;
    private const CURRENCY_EUR = 'EUR';
    private $euCountries = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR',
        'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

    public function __construct(BinlistProvider $binProvider, ExchangeRateProvider $exchangeRateProvider)
    {
        $this->binProvider = $binProvider;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    // Generator to read and process input file row by row
    public function getRatesFromFileIterator(string $filePath): \Generator
    {
        $file = fopen($filePath, 'r');
        while (($row = fgets($file)) !== false) {
            if (empty(trim($row))) {
                continue;
            }

            $data = json_decode($row, true);
            yield $this->calculateCommission($data);  // Yield the commission for each row
        }
        fclose($file);
    }

    public function calculateCommission(array $data): float
    {
        $bin = $data['bin'];
        $amount = $data['amount'];
        $currency = $data['currency'];

        $binData = $this->binProvider->getBinData($bin);
        $isEu = $this->isEu($binData->country->alpha2);

        // Use a constant for EUR comparison
        $rate = $currency === self::CURRENCY_EUR ? 1 : $this->exchangeRateProvider->getRate($currency);
        $amntFixed = ($currency === self::CURRENCY_EUR || $rate == 0) ? $amount : $amount / $rate;

        // Return the commission before applying any rounding logic (handled by renderer)
        return $amntFixed * ($isEu ? 0.01 : 0.02);
    }

    private function isEu(string $countryCode): bool
    {
        return in_array($countryCode, $this->euCountries);
    }
}
