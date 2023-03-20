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

$route->get('/json', [JsonController::class, 'index']);
$route->get('/json/fixture', [JsonController::class, 'fixture']);
$route->get('/json/score', [JsonController::class, 'score']);
$route->get('/json/lineups', [JsonController::class, 'lineups']);
$route->get('/json/standings', [JsonController::class, 'standings']);
$route->get('/json/stats', [JsonController::class, 'stats']);

// Users
$route->resource('/dashboard/users', UserController::class);
$route->get('/dashboard/users/2fa/{id}', [UserController::class, 'two_fa']);
