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

    /**
     * @param string $category
     * @return string
     * @throws \Exception
     */
    public function getRandomJokeFromCategory(string $category): string
    {
        try {
            $joke = $this->apiClient->get('jokes/random', [
                'limitTo' => "[$category]"
            ]);
        }
        catch (GuzzleException $e) {
            return 'error';
        }

        return $joke['joke'] ?? 'Api error, no joke';
    }
}
