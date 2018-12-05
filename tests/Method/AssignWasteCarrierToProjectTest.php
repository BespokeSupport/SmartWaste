<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\AssignWasteCarrierToProject;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class AssignWasteCarrierToProjectTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new AssignWasteCarrierToProject();
    }

    public function testInit()
    {
        $uri = new AssignWasteCarrierToProject(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/waste-carriers/12345', $url);
    }

    public function testSuccess()
    {
        $uri = new AssignWasteCarrierToProject(ConvertEntity::ID, ConvertEntity::ID, ConvertEntity::ID);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $this->assertTrue($ret);
    }
}
