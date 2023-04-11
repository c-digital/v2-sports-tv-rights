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
