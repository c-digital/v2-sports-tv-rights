<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for your application. These
| routes are loaded by the RoutingServiceProvider. Now create something great!
|
*/

// Home
$route->get('/', [HomeController::class, 'index']);

// Auth
$route->auth();

// Dashboard
$route->get('/dashboard', [DashboardController::class, 'index']);

$route->get('/bolivia/liga', [BoliviaController::class, 'liga']);
$route->get('/bolivia/copa', [BoliviaController::class, 'copa']);

$route->get('/match/summary', [MatchController::class, 'summary']);
$route->get('/match/lineups', [MatchController::class, 'lineups']);
$route->get('/match/stats', [MatchController::class, 'stats']);
$route->get('/match/heat-map', [MatchController::class, 'heatMap']);
$route->get('/match/standings', [MatchController::class, 'standings']);
$route->get('/match/replay', [MatchController::class, 'replay']);
$route->get('/match/dynamic', [MatchController::class, 'dynamic']);
$route->get('/match/compare', [MatchController::class, 'compare']);
$route->get('/match/referees', [MatchController::class, 'referees']);
$route->get('/match/competition-stats', [MatchController::class, 'competitionStats']);
$route->get('/match/penalty-history', [MatchController::class, 'penaltyHistory']);
$route->get('/match/season-teams-stats', [MatchController::class, 'seasonTeamsStats']);

$route->get('/export', [ExportController::class, 'index']);
$route->post('/export', [ExportController::class, 'export']);

$route->get('/export/standings/{league}', [ExportController::class, 'standings']);
$route->get('/export/fixture/{league}/{round}', [ExportController::class, 'fixture']);
$route->get('/export/lineups/{fixture}', [ExportController::class, 'lineups']);
$route->get('/export/stats/{fixture?}', [ExportController::class, 'stats']);
$route->get('/export/score/{fixture}', [ExportController::class, 'score']);
$route->get('/export/referees/{fixture}', [ExportController::class, 'referees']);
$route->get('/export/playerStats/{fixture}/{player}', [ExportController::class, 'playerStats']);

// Users
$route->resource('/dashboard/users', UserController::class);

$route->get('/test', function () {
	$token = token();
	$outletKey = '1kfk2u28ef3ut1nm5o9tozdg65';

	$response = http()
        ->withToken($token)
        ->get("https://api.performfeeds.com/soccerdata/match/$outletKey?tmcl=d9kukruep5g7fthaknhbo2k2c&live=yes&_fmt=json&_rt=b&_pgSz=1000");

	foreach (json($response->body())->match as $match) {
		$weeks[] = $match->matchInfo->week;
	}

	$weeks = array_unique($weeks);

	foreach ($weeks as $week) {
		$rounds[] = 'Jornada ' . $week;
	}

	sort($rounds, SORT_NATURAL);
});
