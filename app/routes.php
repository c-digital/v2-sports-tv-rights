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

$route->get('/export', [ExportController::class, 'index']);
$route->post('/export', [ExportController::class, 'export']);

$route->get('/export/standings/{league}', [ExportController::class, 'standings']);
$route->get('/export/fixture/{league}/{round}', [ExportController::class, 'fixture']);
$route->get('/export/lineups/{fixture}', [ExportController::class, 'lineups']);
$route->get('/export/stats/{fixture?}', [ExportController::class, 'stats']);
$route->get('/export/score/{fixture}', [ExportController::class, 'score']);
$route->get('/export/referees/{fixture}', [ExportController::class, 'referees']);

// Users
$route->resource('/dashboard/users', UserController::class);

$route->get('/calendar', function () {
	$response = http()
		->withToken('UkifH-of9gN3TcRajcBiILq77kZ2ccRbIKLveOHnArRA9oP52qLXN3SkeYSxol4jzn4oxpQMU-utnM8pysFM3YfhpQa0Qi82Kq3CUkqyQSWpHhAQymhiq1y5dHkXomdtPD1vciRhs9U9PCET_z7z7iPyU1wBu3eTlxWbxahTsRF3444xT7wcKqzg-pldCvz2379InceFAdzKuUkFRwOTqrmoqH1fjPHXBDebma2-lKqfrnEE94Nb8F6_ucO-Ux2UkpDwONbK7aA1AsikblUPWeiRgBTHMLDgAmOyNgyJVqjmHamanODm483JCXqG_kAq9XNu0IQxq0sng77_ZxWAFA')
		->get('https://api.performfeeds.com/soccerdata/tournamentcalendar/1kfk2u28ef3ut1nm5o9tozdg65/active/authorized?_fmt=json&_rt=b');

	return $response;
});

$route->get('/test', function () {

	return date('Y-m-d H:i:s');

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
