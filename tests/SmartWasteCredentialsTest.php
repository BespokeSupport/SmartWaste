<?php

use BespokeSupport\SmartWaste\SmartWasteCredentials;
use PHPUnit\Framework\TestCase;

class SmartWasteCredentialsTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function test__constructEmpty()
    {
        (new SmartWasteCredentials());
    }

    /**
     * @expectedException \ArgumentCountError
     */
    public function test__constructUser()
    {
        (new SmartWasteCredentials('test'));
    }

    public function test__constructUserKeys()
    {
        (new SmartWasteCredentials('test','public', 'private'));

        $this->assertTrue(true);
    }

    public function testParamsForAuthentication()
    {
        $cred = new SmartWasteCredentials('test','public', 'private');

        $auth = $cred->paramsForAuthentication();

        $this->assertArrayHasKey('token', $auth);
        $this->assertArrayHasKey('password', $auth);

        $this->assertEquals($auth['token'], $cred->random);

        $password = md5($cred->random . $cred->private);

        $this->assertEquals($auth['password'], $password);
    }
}
