<?php

namespace DmytroPro\RatesScriptDemo;

interface ExchangeRateProviderInterface
{
    public function getRate($currency);
}