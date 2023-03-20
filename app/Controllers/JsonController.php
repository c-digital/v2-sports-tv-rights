<?php

namespace App\Controllers;

use View;
use DateTime;

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

    public function fixture()
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures', [
                'date' => '2023-03-18',
                'league' => '140',
                'season' => '2022'
            ]);

        $response = json($response->body())->response;

        $data = [];
        $i = 0;

        foreach ($response as $item) {
            $data[$i]['Nombre equipo local'] = $item->teams->home->name;
            $data[$i]['Fecha'] = (new DateTime($item->fixture->date))->format('d-M');
            $data[$i]['Hora'] = (new DateTime($item->fixture->date))->format('H:i');
            $data[$i]['Nombre equipo visitante'] = $item->teams->away->name;

            $i++;
        }

        return $data;
    }

    public function score()
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures', [
                'date' => '2023-03-18',
                'league' => '140',
                'season' => '2022'
            ]);

        $response = json($response->body())->response;

        $i = 0;

        foreach ($response as $item) {
            $data[$i]['Logo equipo local'] = $item->teams->home->logo;
            $data[$i]['Nombre equipo local'] = $item->teams->home->name;
            $data[$i]['Score'] = $item->fixture->status->short == 'NS' ? '' : $item->goals->home . '-' . $item->goals->away;
            $data[$i]['Nombre equipo visitante'] = $item->teams->away->name;
            $data[$i]['Logo equipo visitante'] = $item->teams->away->logo;

            $i++;
        }

        return $data;
    }

    public function lineups()
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures/lineups', [
                'fixture' => get('fixture')
            ]);

        $response = json($response->body())->response;
        
        $data['local']['Equipo'] = $response[0]->team->name;
        $data['local']['Disposición táctica'] = $response[0]->formation;

        for ($i = 0; $i <= 10; $i++) { 
            $data['local']['Equipo titular'][$i]['Numero de camiseta'] = $response[0]->startXI[$i]->player->number;
            $data['local']['Equipo titular'][$i]['Nombre del jugador'] = $response[0]->startXI[$i]->player->name;
        }

        for ($i = 0; $i < count($response[0]->substitutes); $i++) {
            $data['local']['Suplentes'][$i]['Numero de camiseta'] = $response[0]->substitutes[$i]->player->number;
            $data['local']['Suplentes'][$i]['Nombre del jugador'] = $response[0]->substitutes[$i]->player->name;
        }

        $data['local']['Nombre técnico'] = $response[0]->coach->name;

        $data['visitante']['Equipo'] = $response[1]->team->name;
        $data['visitante']['Disposición táctica'] = $response[1]->formation;

        for ($i = 0; $i <= 10; $i++) { 
            $data['visitante']['Equipo titular'][$i]['Numero de camiseta'] = $response[1]->startXI[$i]->player->number;
            $data['visitante']['Equipo titular'][$i]['Nombre del jugador'] = $response[1]->startXI[$i]->player->name;
        }

        for ($i = 0; $i < count($response[1]->substitutes); $i++) {
            $data['visitante']['Suplentes'][$i]['Numero de camiseta'] = $response[1]->substitutes[$i]->player->number;
            $data['visitante']['Suplentes'][$i]['Nombre del jugador'] = $response[1]->substitutes[$i]->player->name;
        }

        $data['visitante']['Nombre técnico'] = $response[1]->coach->name;

        return $data;
    }

    public function standings()
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/standings', [
                'league' => get('league'),
                'season' => get('season')
            ]);

        $response = json($response->body())->response;

        for ($i = 0; $i < count($response[0]->league->standings[0]); $i++) { 
            $data['Posicion'][$i]['Posición'] = $response[0]->league->standings[0][$i]->rank;
            $data['Posicion'][$i]['Nombre del equipo'] = $response[0]->league->standings[0][$i]->team->name;
            $data['Posicion'][$i]['Partidos disputados'] = $response[0]->league->standings[0][$i]->all->played;
            $data['Posicion'][$i]['Puntos'] = $response[0]->league->standings[0][$i]->points;
        }

        return $data;
    }

    public function stats()
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures/statistics', [
                'fixture' => get('fixture')
            ]);

        $response = json($response->body())->response;

        $data = [];

        foreach ($response as $item) {
            $data[$item->team->name]['Corners'] = $item->statistics[7]->value;
            $data[$item->team->name]['Remates totales'] = $item->statistics[2]->value;
            $data[$item->team->name]['Remates al arco'] = $item->statistics[4]->value;
            $data[$item->team->name]['Faltas'] = $item->statistics[6]->value;
            $data[$item->team->name]['Offside'] = $item->statistics[8]->value;
            $data[$item->team->name]['Posesion'] = $item->statistics[9]->value;
            $data[$item->team->name]['Amarillas'] = $item->statistics[10]->value;
            $data[$item->team->name]['Expulsados'] = $item->statistics[11]->value;
            $data[$item->team->name]['Goles esperados'] = $item->statistics[16]->value;
        }

        return $data;
    }
}
