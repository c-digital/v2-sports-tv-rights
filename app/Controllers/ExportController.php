<?php

namespace App\Controllers;

use DateTime;
use View;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('export.index');
    }

    public function export()
    {
        $season = request('league') == 344 || request('league') == 964 ? '2023' : '2022';

        $data = [];
        $i = 0;
        $class = '';

        switch (request('type')) {
            case 'standings':
                $class = 'App\Excel\Standings';

                $response = http()
                    ->withHeaders([
                        'x-rapidapi-host' => 'v3.football.api-sports.io',
                        'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                    ])
                    ->get('https://v3.football.api-sports.io/standings', [
                        'league' => request('league'),
                        'season' => $season
                    ]);

                $response = json($response->body())->response;

                for ($i = 0; $i < count($response[0]->league->standings[0]); $i++) { 
                    $data[$i]['position'] = $response[0]->league->standings[0][$i]->rank;
                    $data[$i]['team'] = $response[0]->league->standings[0][$i]->team->name;
                    $data[$i]['played'] = $response[0]->league->standings[0][$i]->all->played;
                    $data[$i]['points'] = $response[0]->league->standings[0][$i]->points;
                }
            break;

            case 'fixture':
                $class = 'App\Excel\Fixture';

                $response = http()
                    ->withHeaders([
                        'x-rapidapi-host' => 'v3.football.api-sports.io',
                        'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                    ])
                    ->get('https://v3.football.api-sports.io/fixtures', [
                        'date' => request('date'),
                        'league' => request('league'),
                        'season' => $season
                    ]);

                $response = json($response->body())->response;

                foreach ($response as $item) {
                    $data[$i]['local'] = $item->teams->home->name;
                    $data[$i]['date'] = (new DateTime($item->fixture->date))->format('d-M');
                    $data[$i]['time'] = (new DateTime($item->fixture->date))->format('H:i');
                    $data[$i]['away'] = $item->teams->away->name;

                    $i++;
                }
            break;

            case 'lineups':
                $class = 'App\Excel\Lineups';

                $response = http()
                    ->withHeaders([
                        'x-rapidapi-host' => 'v3.football.api-sports.io',
                        'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                    ])
                    ->get('https://v3.football.api-sports.io/fixtures/lineups', [
                        'fixture' => request('fixture')
                    ]);

                $response = json($response->body())->response;
                
                $data['local']['team'] = $response[0]->team->name;
                $data['local']['formation'] = $response[0]->formation;

                for ($i = 0; $i <= 10; $i++) { 
                    $data['local']['startXI'][$i]['number'] = $response[0]->startXI[$i]->player->number;
                    $data['local']['startXI'][$i]['name'] = $response[0]->startXI[$i]->player->name;
                }

                for ($i = 0; $i < count($response[0]->substitutes); $i++) {
                    $data['local']['substitutes'][$i]['number'] = $response[0]->substitutes[$i]->player->number;
                    $data['local']['substitutes'][$i]['name'] = $response[0]->substitutes[$i]->player->name;
                }

                $data['local']['coach'] = $response[0]->coach->name;

                $data['away']['team'] = $response[1]->team->name;
                $data['away']['formation'] = $response[1]->formation;

                for ($i = 0; $i <= 10; $i++) { 
                    $data['away']['startXI'][$i]['number'] = $response[1]->startXI[$i]->player->number;
                    $data['away']['startXI'][$i]['name'] = $response[1]->startXI[$i]->player->name;
                }

                for ($i = 0; $i < count($response[1]->substitutes); $i++) {
                    $data['away']['substitutes'][$i]['number'] = $response[1]->substitutes[$i]->player->number;
                    $data['away']['substitutes'][$i]['name'] = $response[1]->substitutes[$i]->player->name;
                }

                $data['away']['coach'] = $response[1]->coach->name;
            break;

            case 'referees':
            break;

            case 'stats':
                $class = 'App\Excel\Stats';

                $response = http()
                    ->withHeaders([
                        'x-rapidapi-host' => 'v3.football.api-sports.io',
                        'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                    ])
                    ->get('https://v3.football.api-sports.io/fixtures/statistics', [
                        'fixture' => request('fixture')
                    ]);

                $response = json($response->body())->response;

                foreach ($response as $item) {
                    $data[$item->team->name]['corners'] = $item->statistics[7]->value;
                    $data[$item->team->name]['shots'] = $item->statistics[2]->value;
                    $data[$item->team->name]['shots_on_goal'] = $item->statistics[4]->value;
                    $data[$item->team->name]['fouls'] = $item->statistics[6]->value;
                    $data[$item->team->name]['offside'] = $item->statistics[8]->value;
                    $data[$item->team->name]['possession'] = $item->statistics[9]->value;
                    $data[$item->team->name]['yellows'] = $item->statistics[10]->value;
                    $data[$item->team->name]['reds'] = $item->statistics[11]->value;
                    $data[$item->team->name]['expected_goals'] = $item->statistics[16]->value ?? null;
                }
            break;

            case 'heatMap':
            break;

            case 'score':
                $class = 'App\Excel\Score';

                $response = http()
                    ->withHeaders([
                        'x-rapidapi-host' => 'v3.football.api-sports.io',
                        'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                    ])
                    ->get('https://v3.football.api-sports.io/fixtures', [
                        'date' => request('date'),
                        'league' => request('league'),
                        'season' => $season
                    ]);

                $response = json($response->body())->response;

                foreach ($response as $item) {
                    $data[$i]['local_logo'] = $item->teams->home->logo;
                    $data[$i]['local_name'] = $item->teams->home->name;
                    $data[$i]['score'] = $item->fixture->status->short == 'NS' ? '' : $item->goals->home . '-' . $item->goals->away;
                    $data[$i]['away_name'] = $item->teams->away->name;
                    $data[$i]['away_logo'] = $item->teams->away->logo;

                    $i++;
                }
            break;
        }

        $filename = '/resources/assets/files/excel/' . request('type') . '.xlsx';

        excel($filename, new $class($data));

        return redirect('/export?filename=' . $filename);
    }
}
