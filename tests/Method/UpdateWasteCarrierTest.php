<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Entity\SWWasteCarrier;
use BespokeSupport\SmartWaste\Method\UpdateWasteCarrier;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class UpdateWasteCarrierTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new UpdateWasteCarrier();
    }

    public function testInit()
    {
        $ent = new SWWasteCarrier();

        $uri = new UpdateWasteCarrier(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID, $ent);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/waste-carriers/12345', $url);
    }

    public function testSuccess()
    {
        $ent = new SWWasteCarrier();

        $uri = new UpdateWasteCarrier(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID, $ent);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $val = $ret->carrierID ?? null;

        $this->assertEquals(90524, $val);
    }
}
