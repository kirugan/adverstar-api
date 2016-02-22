<?php
namespace Kirugan\Advertstar;

use Kirugan\Advertstar\Api\ForbiddenException;
use Kirugan\Advertstar\Api\Exception;
use Kirugan\Advertstar\Stats\GeneralStatsRequest;

class Api
{
    const BASE_URI = 'https://advertstar.net/api/';

    private $client;
    private $key;

    public function __construct($apiKey, array $config = [])
    {
        $config['base_uri'] = self::BASE_URI;
        $this->client = new \GuzzleHttp\Client($config);
        $this->key = $apiKey;
    }

    public function generalStats(GeneralStatsRequest $request)
    {
        return $this->call($request->getName(), $request->getData());
    }

    public function call($name, array $data = [])
    {
        $body = $this->client->post($name, [
            'headers' => [
                'Authorization' => sprintf('Token token=%s', $this->key),
                'Accept' => '*/*' // they respond with 406 if we didn`t send Accept header
            ],
            'json' => $data
        ])->getBody();

        // @todo bad json error handling
        $response = json_decode($body, true);
        if (isset($response['error'])) {
            switch ($response['status']) {
                case 401:
                    $class = ForbiddenException::class;
                    break;
                default:
                    $class = Exception::class;
                    break;
            }

            throw new $class($response['error'], $response['status']);
        }

        return $response;
    }
}