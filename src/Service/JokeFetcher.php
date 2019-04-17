<?php

namespace App\Service;


use GuzzleHttp\Exception\GuzzleException;

/**
 * Class JokeFetcher
 * @package App\Service
 */
class JokeFetcher
{
    /** @var JokeApiClient  */
    private $apiClient;

    /**
     * JokeFetcher constructor.
     * @param $apiClient
     */
    public function __construct(JokeApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCategories()
    {
        try {
            $categories = $this->apiClient->get('categories');
        }
        catch (GuzzleException $e) {
            return ['error'];
        }

        return $categories;
    }
}
