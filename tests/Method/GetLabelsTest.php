<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\GetLabels;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class GetLabelsTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new GetLabels();
    }

    public function testInit()
    {
        $uri = new GetLabels(ConvertEntity::ID, ConvertEntity::ID);

        $this->assertTrue(true);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/labels', $url);
    }

    public function testSuccess()
    {
        $uri = new GetLabels(ConvertEntity::ID, ConvertEntity::ID);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $this->assertCount(2, $ret);

        $val = $ret[1]->labelName ?? null;
        $this->assertEquals('Approved', $val);
    }
}
