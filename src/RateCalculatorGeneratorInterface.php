<?php

namespace DmytroPro\RatesScriptDemo;

interface RateCalculatorGeneratorInterface
{
    public function getRatesFromFileGenerator(string $filePath): \Generator;
}