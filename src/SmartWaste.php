<?php

namespace BespokeSupport\SmartWaste;

use BespokeSupport\SmartWaste\Exception\SmartWasteExceptionAuthorisation;
use BespokeSupport\SmartWaste\Exception\SmartWasteExceptionConnection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Class SmartWaste
 * @package BespokeSupport\SmartWaste
 *
 * Url : https://www.smartwaste.co.uk/smarter/login.jsp
 * Docs : http://api.smartwaste.co.uk
 */
class SmartWaste
{
    public static $cachedUsers = [];
    public static $cachedProjects = [];

    /**
     * @param Client $client
     * @param string $method
     * @param string $url
     * @return mixed|ResponseInterface
     */
    private static function requestSend(Client $client, string $method, string $url)
    {
        try {
            $res = $client->request($method, $url);
        } catch (GuzzleException $e) {
            throw new SmartWasteExceptionConnection($e->getMessage(), $e->getCode(), $e);
        }

        if ($res->getStatusCode() === 401) {
            throw new SmartWasteExceptionAuthorisation();
        }

        return $res;
    }

    /**
     * @param SmartWasteCredentials $credentials
     * @param string $endpoint
     * @param array $params
     * @param Client|null $client
     * @return array|object
     */
    public static function api(SmartWasteCredentials $credentials, string $endpoint, array $params = [], Client $client = null)
    {
        $client = $client ?? self::client($credentials, $params);

        $url = SmartWasteRoutes::$uri[$endpoint] ?? null;

        $method = SmartWasteRoutes::$methods[$endpoint] ?? null;

        if (!$method) {
            throw new RuntimeException();
        }

        $res = self::requestSend($client, $method, $url);

        $json = self::responseToJson($res);

        return $json;
    }

    /**
     * @param SmartWasteCredentials $credentials
     * @param $obj
     * @param array $params
     * @param Client|null $client
     * @return mixed
     */
    public static function call(SmartWasteCredentials $credentials, $obj, array $params = [], Client $client = null)
    {
        $client = $client ?? self::client($credentials, $params);

        $endpoint = SmartWasteRoutes::classToShort($obj);

        $method = SmartWasteRoutes::$methods[$endpoint] ?? null;

        $url = SmartWasteRoutes::toUrlRelative($obj);

        $res = self::requestSend($client, $method, $url);

        return self::parse($res, $endpoint);
    }

    /**
     * @param Response $response
     * @param $endpoint
     * @return mixed
     */
    public static function parse(Response $response, $endpoint)
    {
        $json = self::responseToJson($response);

        $endpointClass = ucwords($endpoint);

        $parseClass = "\\BespokeSupport\\SmartWaste\\Parse\\Parse$endpointClass";

        if (class_exists($parseClass) && method_exists($parseClass, 'parse')) {
            return $parseClass::parse($json);
        }

        return $json;
    }

    /**
     * @param $endpointObj
     * @return array
     */
    public static function params($endpointObj)
    {
        $endpointClass = SmartWasteRoutes::toUrlRelative($endpointObj);

        $parseClass = "\\BespokeSupport\\SmartWaste\\Parse\\Parse$endpointClass";

        if (class_exists($parseClass) && method_exists($parseClass, 'params')) {
            return $parseClass::params($endpointObj);
        }

        return [];
    }

    /**
     * @param SmartWasteCredentials $credentials
     * @param array $params
     * @return Client
     */
    public static function client(SmartWasteCredentials $credentials, array $params = []): Client
    {
        $options = [
            'query' => [],
            'base_uri' => SmartWasteRoutes::URL_API,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
            ]
        ];

        if ($params) {
            $options['multipart'] = [];
            foreach ($params as $key => $val) {
                $options['multipart'][] = [
                    'name' => $key,
                    'contents' => $val,
                ];
            }
        }

        $options['query']['username'] = $credentials->user;
        $options['query']['authToken'] = $credentials->token;

        return new Client($options);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws RuntimeException
     */
    private static function responseToJson(ResponseInterface $response)
    {
        $contents = $response->getBody()->getContents();

        $json = json_decode($contents);

        if ($json && !\is_string($json)) {
            return $json;
        }

        throw new RuntimeException($contents);
    }

    /**
     * @param SmartWasteCredentials $credentials
     * @param Client|null $client
     * @return SmartWasteCredentials|null
     */
    public static function tokenize(SmartWasteCredentials $credentials, Client $client = null): ?SmartWasteCredentials
    {
        return self::token($credentials->user, $credentials->public, $credentials->private, $client);
    }

    /**
     * @param string $user
     * @param string $keyPublic
     * @param string $keyPrivate
     * @param Client|null $client
     * @return SmartWasteCredentials|null
     */
    public static function token(string $user, string $keyPublic, string $keyPrivate, Client $client = null): ?SmartWasteCredentials
    {
        if (array_key_exists($user, SmartWaste::$cachedUsers)) {
            return SmartWaste::$cachedUsers[$user];
        }

        $credentials = new SmartWasteCredentials($user, $keyPublic, $keyPrivate);

        $params = $credentials->paramsForAuthentication();

        $client = $client ?? self::client($credentials);

        try {
            $res = $client->request('GET', 'authenticate', [
                'query' => $params
            ]);
        } catch (GuzzleException $e) {
            return null;
        }

        if ($res->getStatusCode() === 500) {
            return null;
        }

        $json = self::responseToJson($res);

        $token = $json->authToken ?? null;

        // TODO
//        if (!$token) {
//            return null;
//        }

        $credentials->token = $token;

        SmartWaste::$cachedUsers[$user] = $credentials;

        return $credentials;
    }
}
