<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SportsApiService
{
    private string $baseUrl = 'https://v3.football.api-sports.io/';
    private string $apiKey = '12482d966b145f78eaadabd6a5c17a37';

    public function getEvents($date)
    {
        $headers = [
            'X-RapidAPI-Key' => $this->apiKey,
        ];

        $url = 'fixtures';
        $params = [
            'date' => $date,
        ];

        $response = Http::withHeaders($headers)->get($this->baseUrl . $url, $params);

        if ($response->successful()) {
            $data = $response->json();
            return $data['response'] ?? [];
        }

        return [];
    }
}
