<?php

namespace App\Controllers;

class JsonController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures', [
                'date' => now('Y-m-d'),
                'league' => 344,
                'season' => now('Y')
            ]);

        return $response->body();
    }
}
