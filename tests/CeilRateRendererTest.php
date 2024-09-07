<?php

use DmytroPro\RatesScriptDemo\CeilRateRenderer;
use PHPUnit\Framework\TestCase;

class CeilRateRendererTest extends TestCase
{
    public function testRender()
    {
        $renderer = new CeilRateRenderer();
        $commission = 0.46180844185832;

        // Expected result after applying ceil logic
        $expected = 0.47;

        // Assert the result
        $this->assertEquals($expected, $renderer->render($commission));
    }
}
