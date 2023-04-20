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
        
        if (auth()->role != 'admin' && auth()->role != 'producer') {
            return abort(401);
        }
        
        $rounds = [];
        $matches = [];
        $players = [];

        $season = get('league') == 344 || get('league') == 964 ? '2023' : '2022';

        if (get('league') && get('type') != 'standings') {
            $response = http()
                ->withToken($this->token)
                ->get("https://api.performfeeds.com/soccerdata/match/$this->outletKey?tmcl=d9kukruep5g7fthaknhbo2k2c&live=yes&_fmt=json&_rt=b&_pgSz=1000");

            foreach (json($response->body())->match as $match) {
                $weeks[] = $match->matchInfo->week;
            }

            $weeks = array_unique($weeks);

            foreach ($weeks as $week) {
                $rounds[] = 'Jornada ' . $week;
            }

            sort($rounds, SORT_NATURAL);
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
                $week = str_replace('Jornada ', '', get('round'));

                $response = http()
                    ->withToken($this->token)
                    ->get('https://api.performfeeds.com/soccerdata/match/' . $this->outletKey . '?tmcl=d9kukruep5g7fthaknhbo2k2c&live=yes&_fmt=json&_rt=b&_pgSz=1000&week=' . $week);

                $matches = json($response->body())->match;
            }
        }

        if (get('type') == 'playerStats' && get('fixture')) {
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
        if ($league == '344') {
            $tournamentCalendarId = 'd9kukruep5g7fthaknhbo2k2c';
        }

        if ($league == '964') {
            $tournamentCalendarId = 'acjvtl7xxvcbcz107c8lieqz8';

            $response = http()
                ->withToken($this->token)
                ->get('https://api.performfeeds.com/soccerdata/standings/' . $this->outletKey . '?live=yes&tmcl=' . $tournamentCalendarId . '&_fmt=json&_rt=b');

            $response = json($response->body())->stage[0]->division;

            foreach ($response as $item) {
                if ($item->type == 'total') {
                    $i = 0;

                    foreach ($item->ranking as $ranking) {
                        $groupName = str_replace('Group', 'Grupo', $item->groupName);

                        $data[$groupName][$i]['position'] = $ranking->rank;
                        $data[$groupName][$i]['team'] = $ranking->contestantClubName;
                        $data[$groupName][$i]['played'] = $ranking->matchesPlayed;
                        $data[$groupName][$i]['points'] = $ranking->points;

                        $i++;
                    }
                }
            }

            return view('export.standings-per-groups', compact('data'));
        }

        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/standings/' . $this->outletKey . '?live=yes&tmcl=' . $tournamentCalendarId . '&_fmt=json&_rt=b');

        $response = json($response->body())->stage[0]->division[0]->ranking;

        $i = 0;

        foreach ($response as $item) {
            $data[$i]['position'] = $item->rank;
            $data[$i]['team'] = $item->contestantClubName;
            $data[$i]['played'] = $item->matchesPlayed;
            $data[$i]['points'] = $item->points;

            $i++;
        }

        return view('export.standings', compact('data'));
    }

    public function fixture($league, $round)
    {
        $season = $league == 344 || $league == 964 ? '2023' : '2022';

        $week = str_replace('Jornada ', '', $round);

        $response = http()
            ->withToken($this->token)
            ->get('https://api.performfeeds.com/soccerdata/match/' . $this->outletKey . '?tmcl=d9kukruep5g7fthaknhbo2k2c&live=yes&_fmt=json&_rt=b&_pgSz=1000&week=' . $week);

        $response = json($response->body());

        $i = 0;

        foreach ($response->match as $item) {
            $data[$i]['local'] = explode(' vs ', $item->matchInfo->description)[0];
            $data[$i]['date'] = (new DateTime($item->matchInfo->localDate))->format('d-M');
            $data[$i]['datetime'] = (new DateTime($item->matchInfo->localDate))->format('Y-m-d H:i:s');
            $data[$i]['time'] = ((new DateTime($item->matchInfo->localTime))->modify('-4hour'))->format('H:i');
            $data[$i]['away'] = explode(' vs ', $item->matchInfo->description)[1];
            
            if ($item->liveData->matchDetails->matchStatus != 'Fixture') {
                $result = $item->liveData->matchDetails->scores->total->home . '-' . $item->liveData->matchDetails->scores->total->away;

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
                    $data['local']['startXI'][$i]['name'] = $response->liveData->lineUp[0]->player[$i]->firstName . ' ' . $response->liveData->lineUp[0]->player[$i]->lastName;
                } else {
                    $data['local']['substitutes'][$j]['number'] = $response->liveData->lineUp[0]->player[$i]->shirtNumber;
                    $data['local']['substitutes'][$j]['name'] = $response->liveData->lineUp[0]->player[$i]->firstName . ' ' . $response->liveData->lineUp[0]->player[$i]->lastName;
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
                    $data['away']['startXI'][$i]['name'] = $response->liveData->lineUp[1]->player[$i]->firstName . ' ' . $response->liveData->lineUp[1]->player[$i]->lastName;
                } else {
                    $data['away']['substitutes'][$j]['number'] = $response->liveData->lineUp[1]->player[$i]->shirtNumber;
                    $data['away']['substitutes'][$j]['name'] = $response->liveData->lineUp[1]->player[$i]->firstName . ' ' . $response->liveData->lineUp[1]->player[$i]->lastName;
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

                if ($stat->type == 'secondYellow') {
                    $data[$home]['second_yellow'] = $stat->value;
                }

                if ($stat->type == 'totalRedCard') {
                    $data[$home]['reds'] = $stat->value;
                }

                if ($stat->type == 'totalPass') {
                    $data[$home]['passes'] = $stat->value;
                }

                if ($stat->type == 'accuratePass') {
                    $data[$home]['successfulPasses'] = $stat->value;
                }

                if ($stat->type == 'totalFinalThirdPasses') {
                    $data[$home]['passesLastThird'] = $stat->value;
                }

                if ($stat->type == 'accuratePass') {
                    $data[$home]['accuratePass'] = $stat->value;
                }

                if ($stat->type == 'totalPass') {
                    $data[$home]['totalPass'] = $stat->value;
                }

                if (isset($data[$home]['accuratePass']) && isset($data[$home]['totalPass'])) {
                    $data[$home]['precision'] = number_format(($data[$home]['accuratePass'] / $data[$home]['totalPass']) * 100, 2);
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

                if ($stat->type == 'secondYellow') {
                    $data[$away]['second_yellow'] = $stat->value;
                }

                if ($stat->type == 'totalRedCard') {
                    $data[$away]['reds'] = $stat->value;
                }

                if ($stat->type == 'totalPass') {
                    $data[$away]['passes'] = $stat->value;
                }

                if ($stat->type == 'accuratePass') {
                    $data[$away]['successfulPasses'] = $stat->value;
                }

                if ($stat->type == 'totalFinalThirdPasses') {
                    $data[$away]['passesLastThird'] = $stat->value;
                }

                if ($stat->type == 'accuratePass') {
                    $data[$away]['accuratePass'] = $stat->value;
                }

                if ($stat->type == 'totalPass') {
                    $data[$away]['totalPass'] = $stat->value;
                }

                if (isset($data[$away]['accuratePass']) && isset($data[$away]['totalPass'])) {
                    $data[$away]['precision'] = number_format(($data[$away]['accuratePass'] / $data[$away]['totalPass']) * 100, 2);
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
                $position = $item->position;
                $item = (array) $item->stat;

                $i = array_search('goals', array_column($item, 'type'));

                if ($i) {
                    $stats['goals'] = $item[$i]->value;
                }

                $i = array_search('ontargetScoringAtt', array_column($item, 'type'));

                if ($i) {
                    $stats['shots_on_goal'] = $item[$i]->value;
                }

                $i = array_search('totalScoringAtt', array_column($item, 'type'));

                if ($i) {
                    $stats['shots'] = $item[$i]->value;
                }

                $i = array_search('touches', array_column($item, 'type'));

                if ($i) {
                    $stats['touches'] = $item[$i]->value;
                }

                $i = array_search('totalPass', array_column($item, 'type'));

                if ($i) {
                    $stats['pass'] = $item[$i]->value;
                }

                $i = array_search('accuratePass', array_column($item, 'type'));

                if ($i) {
                    $stats['successful_pass'] = $item[$i]->value;
                }

                $i = array_search('bigChanceCreated', array_column($item, 'type'));

                if ($i) {
                    $stats['great_scoring_chances'] = $item[$i]->value;
                }

                if ($stats['pass'] != '') {
                    $i = array_search('totalPass', array_column($item, 'type'));

                    if ($i) {
                        $stats['percentage_successful_pass'] = ($stats['successful_pass'] * 100) / $stats['pass'];
                        $stats['percentage_successful_pass'] = number_format($stats['percentage_successful_pass'], 2);
                        $stats['percentage_successful_pass'] = $stats['percentage_successful_pass'] . '%';
                    }
                }

                $i = array_search('wasFouled', array_column($item, 'type'));

                if ($i) {
                    $stats['fouls_received'] = $item[$i]->value ?? 0;
                }

                $i = array_search('fouls', array_column($item, 'type'));

                if ($i) {
                    $stats['fouls'] = $item[$i]->value ?? 0;
                }

                $i = array_search('duelWons', array_column($item, 'type'));

                if ($i) {
                    $stats['duel_wons'] = $item[$i]->value ?? 0;
                }

                $i = array_search('ballRecovery', array_column($item, 'type'));

                if ($i) {
                    $stats['recoveries'] = $item[$i]->value ?? 0;
                }

                if ($position == 'Goalkeeper') {
                    $i = array_search('saves', array_column($item, 'type'));

                    if ($i) {
                        $stats['stops'] = $item[$i]->value ?? 0;
                    }

                    $i = array_search('attemptsConcededIbox', array_column($item, 'type'));
                    $j = array_search('attemptsConcededObox', array_column($item, 'type'));

                    if ($i || $j) {
                        $ibox = $item[$i]->value ?? 0;
                        $obox = $item[$j]->value ?? 0;

                        $stats['auctions_received'] = $ibox;

                        if ($stats['auctions_received'] != '') {
                            $stats['percentage_stops'] = ($stats['stops'] * 100) / $stats['auctions_received'];
                            $stats['percentage_stops'] = number_format($stats['percentage_stops'], 2) . '%';
                        }
                    }
                }
            }
        }

        foreach ($response->liveData->lineUp[1]->player as $item) {
            if ($item->playerId == $player) {
                $data = $item;
                $position = $item->position;
                $item = (array) $item->stat;

                $i = array_search('goals', array_column($item, 'type'));

                if ($i) {
                    $stats['goals'] = $item[$i]->value;
                }

                $i = array_search('ontargetScoringAtt', array_column($item, 'type'));

                if ($i) {
                    $stats['shots_on_goal'] = $item[$i]->value;
                }

                $i = array_search('totalScoringAtt', array_column($item, 'type'));

                if ($i) {
                    $stats['shots'] = $item[$i]->value;
                }

                $i = array_search('touches', array_column($item, 'type'));

                if ($i) {
                    $stats['touches'] = $item[$i]->value;
                }

                $i = array_search('totalPass', array_column($item, 'type'));

                if ($i) {
                    $stats['pass'] = $item[$i]->value;
                }

                $i = array_search('accuratePass', array_column($item, 'type'));

                if ($i) {
                    $stats['successful_pass'] = $item[$i]->value;
                }

                $i = array_search('bigChanceCreated', array_column($item, 'type'));

                if ($i) {
                    $stats['great_scoring_chances'] = $item[$i]->value;
                }

                if ($stats['pass'] != '') {
                    $i = array_search('totalPass', array_column($item, 'type'));

                    if ($i) {
                        $stats['percentage_successful_pass'] = ($stats['successful_pass'] * 100) / $stats['pass'];
                        $stats['percentage_successful_pass'] = number_format($stats['percentage_successful_pass'], 2);
                        $stats['percentage_successful_pass'] = $stats['percentage_successful_pass'] . '%';
                    }
                }

                $i = array_search('wasFouled', array_column($item, 'type'));

                if ($i) {
                    $stats['fouls_received'] = $item[$i]->value ?? 0;
                }

                $i = array_search('totalAttAssist', array_column($item, 'type'));

                if ($i) {
                    $stats['created_occasions'] = $item[$i]->value ?? 0;
                }

                $i = array_search('totalTackle', array_column($item, 'type'));

                if ($i) {
                    $stats['interception'] = $item[$i]->value ?? 0;
                }

                $i = array_search('intersections', array_column($item, 'type'));

                if ($i) {
                    $stats['entries'] = $item[$i]->value ?? 0;
                }

                $i = array_search('fouls', array_column($item, 'type'));

                if ($i) {
                    $stats['fouls'] = $item[$i]->value ?? 0;
                }

                $i = array_search('duelWons', array_column($item, 'type'));

                if ($i) {
                    $stats['duel_wons'] = $item[$i]->value ?? 0;
                }

                $i = array_search('ballRecovery', array_column($item, 'type'));

                if ($i) {
                    $stats['recoveries'] = $item[$i]->value ?? 0;
                }

                if ($position == 'Goalkeeper') {
                    $i = array_search('saves', array_column($item, 'type'));

                    if ($i) {
                        $stats['stops'] = $item[$i]->value ?? 0;
                    }

                    $i = array_search('attemptsConcededIbox', array_column($item, 'type'));
                    $j = array_search('attemptsConcededObox', array_column($item, 'type'));

                    if ($i || $j) {
                        $ibox = $item[$i]->value ?? 0;
                        $obox = $item[$j]->value ?? 0;

                        $stats['auctions_received'] = $ibox;

                        if ($stats['auctions_received'] != '') {
                            $stats['percentage_stops'] = ($stats['stops'] * 100) / $stats['auctions_received'];
                            $stats['percentage_stops'] = number_format($stats['percentage_stops'], 2) . '%';
                        }
                    }
                }
            }
        }

        return view('export.player-stats', compact('data', 'stats', 'position'));
    }
}
