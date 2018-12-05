<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\Authenticate;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteCredentials;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use BespokeSupport\SmartWasteTests\TestHelper;
use PHPUnit\Framework\TestCase;

class AuthenticateTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new Authenticate();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoUser()
    {
        $cred = new SmartWasteCredentials('', '', '');

        $client = TestHelper::clientAuthenticateFail();

        $cred = SmartWaste::tokenize($cred, $client);

        $token = $cred->token ?? null;

        $this->assertNotNull($token);
    }

    public function testInit()
    {
        $uri = new Authenticate('test');

        $this->assertTrue(true);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('authenticate/test', $url);
    }
}
