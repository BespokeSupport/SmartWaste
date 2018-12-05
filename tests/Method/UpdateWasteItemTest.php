<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Entity\SWWasteItem;
use BespokeSupport\SmartWaste\Method\UpdateWasteItem;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class UpdateWasteItemTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new UpdateWasteItem();
    }

    public function testInit()
    {
        // TODO bug - WasteID required in both URL and params
        $this->markTestSkipped('TODO bug - WasteID required in both URL and params');

        $ent = new SWWasteItem();

        $uri = new UpdateWasteItem(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID, $ent);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/waste-item/12345', $url);
    }

    public function testSuccess()
    {
        // TODO bug - WasteID required in both URL and params
        $this->markTestSkipped('TODO bug - WasteID required in both URL and params');

        $ent = new SWWasteItem();

        $uri = new UpdateWasteItem(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID, $ent);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $val = $ret->wasteItemID ?? null;

        $this->assertEquals(90524, $val);
    }
}
