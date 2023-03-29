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

$route->get('/españa/liga', [EspañaController::class, 'liga']);
$route->get('/españa/copa', [EspañaController::class, 'copa']);

$route->get('/inglaterra/liga', [InglaterraController::class, 'liga']);

$route->get('/europa/champions', [EuropaController::class, 'champions']);
$route->get('/europa/europa', [EuropaController::class, 'europa']);

$route->get('/export', [ExportController::class, 'index']);
$route->post('/export', [ExportController::class, 'export']);

$route->get('/export/standings/{league}', [ExportController::class, 'standings']);
$route->get('/export/fixture/{league}/{round}', [ExportController::class, 'fixture']);
$route->get('/export/lineups/{fixture}', [ExportController::class, 'lineups']);
$route->get('/export/stats/{fixture?}', [ExportController::class, 'stats']);
$route->get('/export/score/{fixture}', [ExportController::class, 'score']);

// Users
$route->resource('/dashboard/users', UserController::class);

$route->get('/test', function () {

	$currentMillis = time() * 1000;

	$outletKey = '1kfk2u28ef3ut1nm5o9tozdg65';
	$secretKey = '5xcguj1nyzgd1aufvrjznfxa9';

	$string = $outletKey . $currentMillis . $secretKey;
	$hash = hash('sha512', $string);

	$response = http()
		->withHeaders([
			'Content-Type' => 'application/x-www-form-urlencoded',
			'Authorization' => "Basic $hash",
			'Timestamp' => $currentMillis
		])
        ->post("https://oauth.performgroup.com/oauth/token/$outletKey?_fmt=json&_rt=b", [
        	'grant_type' => 'client_credentials',
        	'scope' => 'b2b-feeds-auth'
        ]);

    return $response;
});
