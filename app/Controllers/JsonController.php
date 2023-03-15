<?php

namespace App\Controllers;

use View;

class JsonController extends Controller
{
    /**
     * Verify if user is logged.
     */
    public function __construct()
    {
        $this->middleware('Auth');
    }

    /**
     * Show home page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('json.index');
    }

    /**
     * Generate and download JSON file.
     */
    public function download()
    {
        $year = [
            '344' => '2023',
            '964' => '2023',
            '140' => '2022',
            '143' => '2022',
            '39' => '2022',
            '2' => '2022',
            '3' => '2022'
        ];

        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures', [
                'date' => request('date'),
                'league' => request('league'),
                'season' => $year[request('league')]
            ]);

        file_put_contents(request('league') . '.json', $response->body());

        $file = $_SERVER['DOCUMENT_ROOT'] . '/' . request('league') . '.json';
        $filename = request('league') . '.json';

        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="' . $filename . '"');
        readfile($file);
    }
}
