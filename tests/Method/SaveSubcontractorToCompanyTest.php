<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Entity\SWSubcontractor;
use BespokeSupport\SmartWaste\Method\SaveSubcontractorToCompany;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class SaveSubcontractorToCompanyTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new SaveSubcontractorToCompany();
    }

    public function testInit()
    {
        $ent = new SWSubcontractor();

        $uri = new SaveSubcontractorToCompany(ConvertEntity::ID, $ent);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('12345/subcontractors', $url);
    }

    public function testSuccess()
    {
        $ent = new SWSubcontractor();

        $uri = new SaveSubcontractorToCompany(ConvertEntity::ID, $ent);

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $val = $ret->subcontractorID ?? null;

        $this->assertEquals(30360, $val);
    }
}
