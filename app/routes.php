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

$route->get('/españa/liga', [EspañaController::class, 'liga']);
$route->get('/españa/copa', [EspañaController::class, 'copa']);

$route->get('/inglaterra/liga', [InglaterraController::class, 'liga']);

$route->get('/europa/champions', [EuropaController::class, 'champions']);
$route->get('/europa/europa', [EuropaController::class, 'europa']);

$route->get('/italia/liga', [ItaliaController::class, 'liga']);
$route->get('/argentina/liga', [ArgentinaController::class, 'liga']);
$route->get('/francia/liga', [FranciaController::class, 'liga']);
$route->get('/alemania/liga', [AlemaniaController::class, 'liga']);

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
	$fixture = '4gw0we8ekau2ydwmtxshtszys';
	$outletKey = '1kfk2u28ef3ut1nm5o9tozdg65';
	$token = token();

	$response = http()
            ->withToken($token)
            ->get('https://api.performfeeds.com/soccerdata/matchstats/' . $outletKey . '/' . $fixture . '?detailed=yes&_rt=b&_fmt=json');

	$response = json($response->body());

	$stats = [];

	foreach ($response->liveData->lineUp as $team) {
		foreach ($team->player as $player) {
			foreach ($player->stat as $stat) {
				$stats[] = $stat->type;
			}
		}
	}

	$stats = array_values(array_unique($stats));

	echo 'return [';

	foreach ($stats as $stat) {
		echo "'$stat' => '',<br>";
	}

	echo ']';
});
