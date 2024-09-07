<?php

namespace DmytroPro\RatesScriptDemo;

class CeilRateRenderer implements RendererInterface
{
    public function render(float $commission): float
    {
        // Apply ceil logic and return the value
        return ceil($commission * 100) / 100;
    }
}