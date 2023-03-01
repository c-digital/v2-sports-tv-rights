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

$route->get('/league', LeagueController::class);
$route->get('/cup', CupController::class);

// Users
$route->resource('/dashboard/users', UserController::class);
$route->get('/dashboard/users/2fa/{id}', [UserController::class, 'two_fa']);
