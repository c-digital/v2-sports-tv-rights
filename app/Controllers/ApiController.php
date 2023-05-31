<?php

namespace App\Controllers;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->token = token();
        $this->outletKey = '1kfk2u28ef3ut1nm5o9tozdg65';
    }

    public function competitions()
    {
        return [
            ['id' => 'd9kukruep5g7fthaknhbo2k2c', 'name' => 'Liga Tigo FBF'],
            ['id' => 'acjvtl7xxvcbcz107c8lieqz8', 'name' => 'Copa Tigo FBF']
        ];
    }

    public function reports()
    {
        return [
            ['id' => 'standings', 'name' => 'Tabla de posiciones'],
            ['id' => 'fixture', 'name' => 'Fixture'],
            ['id' => 'lineups', 'name' => 'Alineaciones'],
            ['id' => 'referees', 'name' => 'Árbitros'],
            ['id' => 'stats', 'name' => 'Estadísticas'],
            ['id' => 'playerStats', 'name' => 'Estadísticas por jugador'],
            ['id' => 'heatMap', 'name' => 'Mapa de calor'],
            ['id' => 'score', 'name' => 'Score'],
            ['id' => 'general', 'name' => 'General']
        ];
    }

    public function rounds($competition)
    {
        $rounds = [];

        $count = $competition == 'd9kukruep5g7fthaknhbo2k2c' ? 34 : 10;

        for ($i = 0; $i <= $count - 1; $i++) {
            $rounds[$i]['id'] = $i + 1;
            $rounds[$i]['name'] = 'Jornada ' . $i + 1;
        }

        return $rounds;
    }

    public function matches($competition, $round)
    {
        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/match/' . $this->outletKey . '?tmcl=' . $competition . '&live=yes&_fmt=json&_rt=b&_pgSz=1000&week=' . $round);

        $matches = [];
        $i = 0;

        foreach (json($response->body())->match as $match) {
            $matches[$i]['id'] = $match->matchInfo->id;
            $matches[$i]['match'] = $match->matchInfo->contestant[0]->name . ' vs ' . $match->matchInfo->contestant[1]->name;

            $i++;
        }

        return $matches;
    }

    public function players($match)
    {
        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $match . '?detailed=yes&_rt=b&_fmt=json');

        $i = 0;

        foreach (json($response->body())->liveData->lineUp[0]->player as $player) {
            $players[$i]['id'] = $player->playerId;
            $players[$i]['name'] = $player->matchName;

            $i++;
        }

        foreach (json($response->body())->liveData->lineUp[1]->player as $player) {
            $players[$i]['id'] = $player->playerId;
            $players[$i]['name'] = $player->matchName;

            $i++;
        }

        return $players;
    }
}
