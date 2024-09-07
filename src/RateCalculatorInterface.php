<?php

namespace DmytroPro\RatesScriptDemo;

interface RateCalculatorInterface
{
    public function calculateCommission(array $data): float;
}