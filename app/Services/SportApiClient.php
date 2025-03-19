<?php

namespace App\Services;

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
     * @return array|mixed
     */
    private function request(string $url, array $params = [])
    {
        $headers = [
            'X-RapidAPI-Key' => $this->apiKey,
        ];

        $response = Http::withHeaders($headers)->get($this->baseUrl . $url, $params);

        return $response->successful() ? $response->json()['response'] ?? [] : [];
    }

    /**
     * @param string $date
     * @return array|mixed
     */
    public function getCurrentFootballMatches(string $date)
    {
        return $this->request('fixtures', ['date' => $date]);
    }

    /**
     * @param array $eventIds
     * @return array|mixed
     */
    public function getResultsFootballMatches(array $eventIds)
    {
        return $this->request('fixtures', ['ids' => implode(',', $eventIds)]);
    }
}

//class SportsApiService
//{
//    private string $baseUrl = 'https://v3.football.api-sports.io/';
//    private string $apiKey = '12482d966b145f78eaadabd6a5c17a37';

//    public function getEvents($date)
//    {
//        $headers = [
//            'X-RapidAPI-Key' => $this->apiKey,
//        ];
//
//        $url = 'fixtures';
//        $params = [
//            'date' => $date,
//        ];
//
//        $response = Http::withHeaders($headers)->get($this->baseUrl . $url, $params);
//
//        if ($response->successful()) {
//            $data = $response->json();
//            return $data['response'] ?? [];
//        }
//
//        return [];
//    }
