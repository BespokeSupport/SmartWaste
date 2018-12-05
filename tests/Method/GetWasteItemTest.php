<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\GetWasteItem;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class GetWasteItemTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new GetWasteItem();
    }

    public function testInit()
    {
        $uri = new GetWasteItem(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID);

        $this->assertTrue(true);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/waste-items/12345', $url);
    }

    public function testSuccess()
    {
        $uri = new GetWasteItem(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = \BespokeSupport\SmartWaste\SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $val = $ret->wasteID ?? null;
        $this->assertEquals(1756110, $val);
    }
}
