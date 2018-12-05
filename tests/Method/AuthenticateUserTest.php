<?php

namespace BespokeSupport\SmartWasteTests\Method;

use BespokeSupport\SmartWaste\Method\AuthenticateUser;
use BespokeSupport\SmartWaste\SmartWasteRoutes;
use PHPUnit\Framework\TestCase;

class AuthenticateUserTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testClass()
    {
        new AuthenticateUser();
    }

    public function testInit()
    {
        $uri = new AuthenticateUser('test');

        $this->assertTrue(true);

        $url = SmartWasteRoutes::toUrlRelative($uri);

        $this->assertEquals('users/test', $url);
    }
}
