<?php

namespace App\Client;

use Illuminate\Support\Facades\Http;

class SportApiClient
{
    private string $apiFootballUrl;
    private string $apiFootballKey;

    public function __construct()
    {
        $this->apiFootballUrl = env('FOOTBALL_API_URL');
        $this->apiFootballKey = env('FOOTBALL_API_KEY');
    }

    /**
     * @param string $url
     * @param array $params
     * @return array
     */
    private function getApiFootballRequest(string $url, array $params = []): array
    {
        $headers = [
            'X-RapidAPI-Key' => $this->apiFootballKey,
        ];

        $response = Http::withHeaders($headers)->get($this->apiFootballUrl . $url, $params);

        return $response->successful() ? $response->json()['response'] ?? [] : [];
    }

    /**
     * @param string $date
     * @return array
     */
    public function getCurrentFootballMatches(string $date): array
    {
        return $this->getApiFootballRequest('fixtures', ['date' => $date]);
    }

    /**
     * @param string $title
     * @return array
     */
    public function getResultsFootballMatches(string $title): array
    {
        $params = [
            'title' => $title,
        ];

        return $this->getApiFootballRequest('fixtures', $params);
    }
}
