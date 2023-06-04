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
$route->get('/login/{user_param}/{password_param}', [AuthController::class, 'loginBasic']);


// Dashboard
$route->get('/dashboard', [DashboardController::class, 'index']);

// Widgets
$route->get('/bolivia/liga', [BoliviaController::class, 'liga']);
$route->get('/bolivia/copa', [BoliviaController::class, 'copa']);

// Match
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

// Drag and drop
$route->get('/match/drag-drop', [DragDropController::class, 'index']);

// Export
$route->get('/export', [ExportController::class, 'index']);
$route->post('/export', [ExportController::class, 'export']);

$route->get('/export/standings/{league}', [ExportController::class, 'standings']);
$route->get('/export/fixture/{league}/{round}', [ExportController::class, 'fixture']);
$route->get('/export/lineups/{fixture}', [ExportController::class, 'lineups']);
$route->get('/export/stats/{fixture?}', [ExportController::class, 'stats']);
$route->get('/export/score/{fixture}', [ExportController::class, 'score']);
$route->get('/export/referees/{fixture}', [ExportController::class, 'referees']);
$route->get('/export/playerStats/{fixture}/{player}', [ExportController::class, 'playerStats']);
$route->get('/export/general/{fixture}', [ExportController::class, 'general']);

$route->get('/api/competitions', [ApiController::class, 'competitions']);
$route->get('/api/reports', [ApiController::class, 'reports']);
$route->get('/api/rounds/{competition}', [ApiController::class, 'rounds']);
$route->get('/api/matches/{competition}/{round}', [ApiController::class, 'matches']);
$route->get('/api/players/{match}', [ApiController::class, 'players']);

// Users
$route->resource('/dashboard/users', UserController::class);
