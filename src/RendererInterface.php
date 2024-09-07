<?php

namespace DmytroPro\RatesScriptDemo;

interface RendererInterface
{
    public function render(float $commission): mixed;
}