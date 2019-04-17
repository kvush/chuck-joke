<?php

namespace App\Service;


use GuzzleHttp\Client;

/**
 * Class JokeApiClient
 * @package App\Service
 */
class JokeApiClient
{
    /** @var Client */
    private $client;

    /**
     * JokeApiClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://api.icndb.com/',
        ]);
    }

    /**
     * @param string $path
     * @param array $query
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function get(string $path, array $query = [])
    {
        $response = $this->client->request('GET', $path, [
            'query' => $query
        ]);
        $content = $response->getBody()->getContents();
        $result = \GuzzleHttp\json_decode($content, true);

        if (!isset($result['value'])) {
            throw new \Exception('Joke API error. Field value does not exists');
        }

        return $result['value'];
    }
}
