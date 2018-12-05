<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\GetSkipSizes;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class GetSkipSizesTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new GetSkipSizes();
    }

    public function testInit()
    {
        $uri = new GetSkipSizes(ConvertEntity::ID, ConvertEntity::ID);

        $this->assertTrue(true);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/skip-sizes', $url);
    }

    public function testSuccess()
    {
        $uri = new GetSkipSizes(ConvertEntity::ID, ConvertEntity::ID);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = \BespokeSupport\SmartWaste\SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $this->assertCount(4, $ret);

        $val = $ret[0]->skipSizeID ?? null;
        $this->assertEquals(172, $val);
    }
}
