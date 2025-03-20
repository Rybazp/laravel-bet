<?php

namespace App\Client;

use Illuminate\Support\Facades\Http;

class SportApiClient
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('FOOTBALL_API_URL');
        $this->apiKey = env('FOOTBALL_API_KEY');
    }

    /**
     * @param string $url
     * @param array $params
     * @return array
     */
    private function request(string $url, array $params = []): array
    {
        $headers = [
            'X-RapidAPI-Key' => $this->apiKey,
        ];

        $response = Http::withHeaders($headers)->get($this->baseUrl . $url, $params);

        return $response->successful() ? $response->json()['response'] ?? [] : [];
    }

    /**
     * @param string $date
     * @return array
     */
    public function getCurrentFootballMatches(string $date): array
    {
        return $this->request('fixtures', ['date' => $date]);
    }

    /**
     * @param array $eventIds
     * @return array
     */
    public function getResultsFootballMatches(array $eventIds): array
    {
        return $this->request('fixtures', ['ids' => implode(',', $eventIds)]);
    }
}
