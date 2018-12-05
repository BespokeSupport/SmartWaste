<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\GetDefaultCompanies;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class GetDefaultCompaniesTest extends TestCase
{
    public function testClass()
    {
        new GetDefaultCompanies();

        $this->assertTrue(true);
    }

    public function testInit()
    {
        $uri = new GetDefaultCompanies();

        $this->assertTrue(true);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('companies', $url);
    }

    public function testSuccess()
    {
        $uri = new GetDefaultCompanies();

        $short = SmartWasteRoutes::classToShort($uri);

        $res = file_get_contents(__DIR__ . "/../Responses/$short.json");

        $client = TestHelper::clientSuccess(json_decode($res));

        $ret = SmartWaste::call(TestHelper::credComplete(), $uri, [], $client);

        $this->assertCount(1, $ret);

        $city = $ret[0]->contactSurname ?? null;
        $this->assertEquals('Admin', $city);
    }
}
