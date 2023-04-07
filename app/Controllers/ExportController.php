<?php

namespace App\Controllers;

use DateTime;
use View;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->token = token();

        $this->outletKey = '1kfk2u28ef3ut1nm5o9tozdg65';
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $this->middleware('Auth');
        
        if (auth()->role != 'admin') {
            return abort(401);
        }
        
        $rounds = [];
        $matches = [];
        $players = [];

        $season = get('league') == 344 || get('league') == 964 ? '2023' : '2022';

        if (get('league') && get('type') != 'standings') {
            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures/rounds', [
                    'league' => request('league'),
                    'season' => $season
                ]);

            $rounds = json($response->body())->response;
        }

        if (get('round')) {
            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures', [
                    'league' => request('league'),
                    'season' => $season,
                    'round' => get('round')
                ]);

            $matches = json($response->body())->response;

            if (get('league') == 344) {
                $week = str_replace('Regular Season - ', '', get('round'));

                $response = http()
                    ->withToken($this->token)
                    ->get('https://api.performfeeds.com/soccerdata/match/' . $this->outletKey . '?tmcl=d9kukruep5g7fthaknhbo2k2c&live=yes&_fmt=json&_rt=b&_pgSz=1000&week=' . $week);

                $matches = json($response->body())->match;
            }
        }

        if (get('type') == 'playerStats') {
            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . get('fixture') . '?detailed=yes&_rt=b&_fmt=json');

            $response = json($response->body());

            $i = 0;

            foreach ($response->liveData->lineUp[0]->player as $player) {
                $players[$i]['id'] = $player->playerId;
                $players[$i]['name'] = $player->matchName;

                $i++;
            }

            foreach ($response->liveData->lineUp[1]->player as $player) {
                $players[$i]['id'] = $player->playerId;
                $players[$i]['name'] = $player->matchName;

                $i++;
            }
        }

        return view('export.index', compact('rounds', 'matches', 'players'));
    }

    public function standings($league)
    {
        $season = $league == 344 || $league == 964 ? '2023' : '2022';

        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/standings', [
                'league' => $league,
                'season' => $season
            ]);

        $response = json($response->body())->response;

        for ($i = 0; $i < count($response[0]->league->standings[0]); $i++) { 
            $data[$i]['position'] = $response[0]->league->standings[0][$i]->rank;
            $data[$i]['team'] = $response[0]->league->standings[0][$i]->team->name;
            $data[$i]['played'] = $response[0]->league->standings[0][$i]->all->played;
            $data[$i]['points'] = $response[0]->league->standings[0][$i]->points;
        }

        if (get('bolivia')) {
            if ($league == '344') {
                $tournamentCalendarId = 'd9kukruep5g7fthaknhbo2k2c';
            }

            if ($league == '964') {
                $tournamentCalendarId = 'acjvtl7xxvcbcz107c8lieqz8';
            }

            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/standings/' . $this->outletKey . '?tmcl=' . $tournamentCalendarId . '&_fmt=json&_rt=b');

            $response = json($response->body())->stage[0]->division[0]->ranking;

            $i = 0;

            foreach ($response as $item) {
                $data[$i]['position'] = $item->rank;
                $data[$i]['team'] = $item->contestantClubName;
                $data[$i]['played'] = $item->matchesPlayed;
                $data[$i]['points'] = $item->points;

                $i++;
            }
        }

        return view('export.standings', compact('data'));
    }

    public function fixture($league, $round)
    {
        $season = $league == 344 || $league == 964 ? '2023' : '2022';

        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures', [
                'round' => $round,
                'league' => $league,
                'season' => $season
            ]);

        $response = json($response->body())->response;

        $i = 0;

        foreach ($response as $item) {
            $data[$i]['local'] = $item->teams->home->name;
            $data[$i]['date'] = (new DateTime($item->fixture->date))->format('d-M');
            $data[$i]['datetime'] = (new DateTime($item->fixture->date))->format('Y-m-d H:i:s');
            $data[$i]['time'] = (new DateTime($item->fixture->date))->format('H:i');
            $data[$i]['away'] = $item->teams->away->name;
            
            if ($item->fixture->status->short == 'FT') {
                $result = $item->goals->home . '-' . $item->goals->away;

                $data[$i]['result'] = $result;
            }

            $i++;
        }

        array_multisort(array_column($data, 'datetime'), SORT_ASC, $data);

        return view('export.fixture', compact('data'));
    }

    public function lineups($fixture)
    {
        if (get('bolivia')) {
            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

            $response = json($response->body());

            $data['local']['team'] = $response->matchInfo->contestant[0]->shortName;
            $data['local']['formation'] = $response->liveData->lineUp[0]->formationUsed;

            $j = 0;

            for ($i = 0; $i <= count($response->liveData->lineUp[0]->player) - 1; $i++) { 
                if ($response->liveData->lineUp[0]->player[$i]->position != 'Substitute') {
                    $data['local']['startXI'][$i]['number'] = $response->liveData->lineUp[0]->player[$i]->shirtNumber;
                    $data['local']['startXI'][$i]['name'] = $response->liveData->lineUp[0]->player[$i]->matchName;
                } else {
                    $data['local']['substitutes'][$j]['number'] = $response->liveData->lineUp[0]->player[$i]->shirtNumber;
                    $data['local']['substitutes'][$j]['name'] = $response->liveData->lineUp[0]->player[$i]->matchName;
                    $j++;
                }
            }

            $data['local']['coach'] = $response->liveData->lineUp[0]->teamOfficial->firstName . ' ' . $response->liveData->lineUp[0]->teamOfficial->lastName;

            $data['away']['team'] = $response->matchInfo->contestant[1]->shortName;
            $data['away']['formation'] = $response->liveData->lineUp[1]->formationUsed;

            $j = 0;

            for ($i = 0; $i <= count($response->liveData->lineUp[1]->player) - 1; $i++) { 
                if ($response->liveData->lineUp[1]->player[$i]->position != 'Substitute') {
                    $data['away']['startXI'][$i]['number'] = $response->liveData->lineUp[1]->player[$i]->shirtNumber;
                    $data['away']['startXI'][$i]['name'] = $response->liveData->lineUp[1]->player[$i]->matchName;
                } else {
                    $data['away']['substitutes'][$j]['number'] = $response->liveData->lineUp[1]->player[$i]->shirtNumber;
                    $data['away']['substitutes'][$j]['name'] = $response->liveData->lineUp[1]->player[$i]->matchName;
                    $j++;
                }
            }

            $data['away']['coach'] = $response->liveData->lineUp[1]->teamOfficial->firstName . ' ' . $response->liveData->lineUp[1]->teamOfficial->lastName;

            $array = [count($data['away']['substitutes']), count($data['local']['substitutes'])];
            $max = max($array);

        } else {
            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures/lineups', [
                    'fixture' => $fixture
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

            $array = [count($data['away']['substitutes']), count($data['local']['substitutes'])];
            $max = max($array);         
        }


        return view('export.lineups', compact('data', 'max'));
    }

    public function stats($fixture = '')
    {
        $response = http()
            ->withHeaders([
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
            ])
            ->get('https://v3.football.api-sports.io/fixtures/statistics', [
                'fixture' => $fixture
            ]);

        $response = json($response->body())->response;

        foreach ($response as $item) {
            $data[$item->team->name]['corners'] = $item->statistics[7]->value ?? 0;
            $data[$item->team->name]['shots'] = $item->statistics[2]->value ?? 0;
            $data[$item->team->name]['shots_on_goal'] = $item->statistics[4]->value ?? 0;
            $data[$item->team->name]['fouls'] = $item->statistics[6]->value ?? 0;
            $data[$item->team->name]['offside'] = $item->statistics[8]->value ?? 0;
            $data[$item->team->name]['possession'] = $item->statistics[9]->value;
            $data[$item->team->name]['yellows'] = $item->statistics[10]->value ?? 0;
            $data[$item->team->name]['reds'] = $item->statistics[11]->value ?? 0;
            $data[$item->team->name]['expected_goals'] = $item->statistics[16]->value ?? '-';
        }

        if (get('bolivia')) {
            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

            $home = explode(' vs ', json($response->body())->matchInfo->description)[0];
            $away = explode(' vs ', json($response->body())->matchInfo->description)[1];

            $response = json($response->body())->liveData;

            $data[$home]['contestantId'] = $response->lineUp[0]->contestantId;

            foreach ($response->lineUp[0]->stat as $stat) {
                if ($stat->type == 'cornerTaken') {
                    $data[$home]['corners'] = $stat->value;
                }

                if ($stat->type == 'totalScoringAtt') {
                    $data[$home]['shots'] = $stat->value;
                }

                if ($stat->type == 'ontargetScoringAtt') {
                    $data[$home]['shots_on_goal'] = $stat->value;
                }

                if ($stat->type == 'fkFoulLost') {
                    $data[$home]['fouls'] = $stat->value;
                }

                if ($stat->type == 'totalOffside') {
                    $data[$home]['offside'] = $stat->value;
                }

                if ($stat->type == 'possessionPercentage') {
                    $data[$home]['possession'] = $stat->value;
                }

                if ($stat->type == 'totalYellowCard') {
                    $data[$home]['yellows'] = $stat->value;
                }                
            }

            $data[$away]['contestantId'] = $response->lineUp[1]->contestantId;

            foreach ($response->lineUp[1]->stat as $stat) {
                if ($stat->type == 'cornerTaken') {
                    $data[$away]['corners'] = $stat->value;
                }

                if ($stat->type == 'totalScoringAtt') {
                    $data[$away]['shots'] = $stat->value;
                }

                if ($stat->type == 'ontargetScoringAtt') {
                    $data[$away]['shots_on_goal'] = $stat->value;
                }

                if ($stat->type == 'fkFoulLost') {
                    $data[$away]['fouls'] = $stat->value;
                }

                if ($stat->type == 'totalOffside') {
                    $data[$away]['offside'] = $stat->value;
                }

                if ($stat->type == 'possessionPercentage') {
                    $data[$away]['possession'] = $stat->value;
                }

                if ($stat->type == 'totalYellowCard') {
                    $data[$away]['yellows'] = $stat->value;
                }                
            }

            $data[$home]['reds'] = 0;
            $data[$away]['reds'] = 0;

            foreach ($response->card as $card) {
                if ($card->type == 'RC' && $card->contestantId == $data[$home]['contestantId']) {
                    $data[$home]['reds'] = $data[$home]['reds'] + 1;
                }

                if ($card->type == 'RC' && $card->contestantId == $data[$away]['contestantId']) {
                    $data[$away]['reds'] = $data[$away]['reds'] + 1;
                }
            }

            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/matchexpectedgoals/' . $this->outletKey . '/' . $fixture . '?_rt=b&_fmt=json');

            $response = json($response->body())->liveData;

            foreach ($response->lineUp[0]->stat as $stat) {
                if ($stat->type == 'expectedGoals') {
                    $data[$home]['expected_goals'] = $stat->value;
                }              
            }

            foreach ($response->lineUp[1]->stat as $stat) {
                if ($stat->type == 'expectedGoals') {
                    $data[$away]['expected_goals'] = $stat->value;
                }              
            }
        }

        if (! isset($data)) {
            return 'No hay info para este partido';
        }

        $local = array_keys($data)[0];
        $away = array_keys($data)[1];

        return view('export.stats', compact('data', 'local', 'away'));
    }

    public function score($fixture)
    {
        if (get('bolivia')) {
            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

            $response = json($response->body());

            $data['local']['team_id'] = $response->matchInfo->contestant[0]->id;
            $data['local']['team'] = $response->matchInfo->contestant[0]->name;
            $data['local']['logo'] = '';

            $data['away']['team_id'] = $response->matchInfo->contestant[1]->id;
            $data['away']['team'] = $response->matchInfo->contestant[1]->name;
            $data['away']['logo'] = '';

            $i = 0;

            foreach ($response->liveData->goal as $goal) {
                $data['goals'][$i]['detail'] = '';
                $data['goals'][$i]['player'] = $goal->scorerName;
                $data['goals'][$i]['time'] = $goal->timeMin;

                if ($goal->contestantId == $response->matchInfo->contestant[0]->id) {
                    $data['goals'][$i]['team'] = $response->matchInfo->contestant[0]->name;
                }

                if ($goal->contestantId == $response->matchInfo->contestant[1]->id) {
                    $data['goals'][$i]['team'] = $response->matchInfo->contestant[1]->name;
                }

                $i++;
            }

        } else {
            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures/lineups', [
                    'fixture' => $fixture
                ]);

            $response = json($response->body())->response;

            $data['local']['team_id'] = $response[0]->team->id;
            $data['local']['team'] = $response[0]->team->name;
            $data['local']['logo'] = $response[0]->team->logo;

            $data['away']['team_id'] = $response[1]->team->id;
            $data['away']['team'] = $response[1]->team->name;
            $data['away']['logo'] = $response[1]->team->logo;

            $response = http()
                ->withHeaders([
                    'x-rapidapi-host' => 'v3.football.api-sports.io',
                    'x-rapidapi-key' => '76e449a048284c4ad2336531b8c06ab2'
                ])
                ->get('https://v3.football.api-sports.io/fixtures/events', [
                    'fixture' => $fixture,
                    'type' => 'Goal'
                ]);

            $response = json($response->body())->response;

            $i = 0;

            foreach ($response as $item) {
                $data['goals'][$i]['detail'] = $item->detail;
                $data['goals'][$i]['team'] = $item->team->name;
                $data['goals'][$i]['player'] = $item->player->name;
                $data['goals'][$i]['time'] = $item->time->elapsed;

                $i++;
            }            
        }


        return view('export.score', compact('data'));
    }

    public function export()
    {
        $request = request();
        $request['copy'] = 1;

        if (request('league') == '344' || request('league') == '964') {
            $request['bolivia'] = 1;
        }

        $queryString = http_build_query($request);

        return redirect('/export?' . $queryString);
    }

    public function referees($fixture)
    {
        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

        $referees = json($response->body())->liveData->matchDetailsExtra->matchOfficial;

        return view('export.referees', compact('referees'));
    }

    public function playerStats($fixture, $player)
    {
        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $this->outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

        $response = json($response->body());

        foreach ($response->liveData->lineUp[0]->player as $item) {
            if ($item->playerId == $player) {
                $data = $item;
            }
        }

        foreach ($response->liveData->lineUp[1]->player as $player) {
            if ($item->playerId == $player) {
                $data = $item;
            }
        }

        return view('export.player-stats', compact('data'));
    }
}
