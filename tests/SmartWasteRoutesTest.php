<?php

use BespokeSupport\SmartWaste\SmartWasteRoutes;
use PHPUnit\Framework\TestCase;

class SmartWasteRoutesTest extends TestCase
{
    public function testV1()
    {
        $this->assertEquals(1, preg_match('#v1/$#', SmartWasteRoutes::URL_API));
    }

    /**
     * @expectedException RuntimeException
     */
    public function test__toUrlRelativeError()
    {
        SmartWasteRoutes::toUrlRelative(new BespokeSupport\SmartWaste\SmartWaste());
    }
}
