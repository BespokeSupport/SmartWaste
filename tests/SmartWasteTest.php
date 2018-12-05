<?php

namespace BespokeSupport\SmartWasteTests;

use BespokeSupport\SmartWaste\SmartWaste;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class SmartWasteTest extends TestCase
{
    /**
     * @expectedException \ArgumentCountError
     */
    public function testTokenEmpty()
    {
        (SmartWaste::token());
    }

    /**
     *
     */
    public function testTokenFail()
    {
        $cred = TestHelper::credComplete();

        $client = TestHelper::clientAuthenticateFail();

        $cred = SmartWaste::token($cred->user, $cred->public, $cred->private, $client);

        $this->assertNull($cred);
    }

    public function testToken()
    {
        $cred = TestHelper::credComplete();

        $client = TestHelper::clientAuthenticateSuccess();

        $cred = SmartWaste::tokenize($cred, $client);

        $this->assertNotNull($cred);
        $this->assertEquals('token', $cred->token);
    }

    public function testTokenCache()
    {
        $cred = TestHelper::credComplete();

        $cred = SmartWaste::token($cred->user, $cred->public, $cred->private, TestHelper::clientAuthenticateSuccess());

        $cred = SmartWaste::token($cred->user, $cred->public, $cred->private, new Client());

        $this->assertNotNull($cred);
        $this->assertEquals('token', $cred->token);
    }

    public function testClient()
    {
        $cred = TestHelper::credComplete();

        $client = SmartWaste::client($cred);

        $this->assertInstanceOf(Client::class, $client);

        $query = $client->getConfig('query');

        $this->assertCount(2, $query);

        $this->assertArrayHasKey('username', $query);

        $params = $client->getConfig('multipart');

        $this->assertNull($params);
    }

    public function testClientParams()
    {
        $cred = TestHelper::credComplete();

        $client = SmartWaste::client($cred, [
            'testKey' => 'testVal',
        ]);

        $this->assertInstanceOf(Client::class, $client);

        $query = $client->getConfig('query');

        $this->assertCount(2, $query);

        $params = $client->getConfig('multipart');

        $this->assertCount(1, $params);

        $this->assertArrayHasKey('name', $params[0]);
        $this->assertEquals('testKey', $params[0]['name']);
        $this->assertEquals('testVal', $params[0]['contents']);
    }

    public function testApi()
    {
        $cred = TestHelper::credComplete();

        $client = TestHelper::clientSuccess();

        $res = SmartWaste::api($cred, 'getProject', [], $client);

        $this->assertNotNull($res);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testTestApi()
    {
        $cred = TestHelper::credComplete();

        $client = TestHelper::clientFailApiError('');

        $res = SmartWaste::api($cred, 'error', [], $client);

        $this->assertNotNull($res);
    }
    /**
     * @expectedException \RuntimeException
     */
    public function testTestApiInvalidResponse()
    {
        $cred = TestHelper::credNotAuth();

        $client = TestHelper::clientException();

        $res = SmartWaste::api($cred, 'valid', [], $client);

        $this->assertNotNull($res);
    }
}
