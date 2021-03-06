<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Entity\SWWasteDestination;
use BespokeSupport\SmartWaste\Method\SaveWasteDestinationToProject;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class SaveWasteDestinationToProjectTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new SaveWasteDestinationToProject();
    }

    public function testInit()
    {
        $ent = new SWWasteDestination();

        $uri = new SaveWasteDestinationToProject(ConvertEntity::ID, ConvertEntity::ID, $ent);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/projects/12345/waste-destinations', $url);
    }

    public function testSuccess()
    {
        $ent = new SWWasteDestination();

        $uri = new SaveWasteDestinationToProject(ConvertEntity::ID, ConvertEntity::ID, $ent);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $val = $ret->destinationID ?? null;

        $this->assertEquals(90464, $val);
    }
}
