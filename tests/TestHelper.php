<?php

namespace BespokeSupport\SmartWasteTests;

use BespokeSupport\SmartWaste\SmartWasteCredentials;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestHelper
{
    public static function credComplete()
    {
        return new SmartWasteCredentials('test', 'public', 'private', 'token');
    }

    public static function credNotAuth()
    {
        return new SmartWasteCredentials('test', 'public', 'private');
    }

    /**
     *
     * @var $success array|\stdClass
     * @return Client
     */
    public static function clientSuccess($success = ['success' => true])
    {
        $mock = new MockHandler([new Response(200, [], json_encode($success))]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    public static function clientFail(array $success = ['success' => false], int $status = 200)
    {
        $mock = new MockHandler([new Response($status, [], json_encode($success))]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    public static function clientException()
    {
        $mock = new MockHandler([new TransferException()]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    public static function clientFailApiError($response, int $status = 400)
    {
        $mock = new MockHandler([new Response($status, [], $response)]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler, 'http_errors' => false]);

        return $client;
    }

    public static function clientAuthenticateSuccess()
    {
        $mock = new MockHandler([new Response(200, [], json_encode([
            'authToken' => 'token',
            'success' => true,
        ]))]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    public static function clientAuthenticateFail()
    {
        $mock = new MockHandler([new Response(400, [], json_encode([
            'success' => false,
        ]))]);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }
}