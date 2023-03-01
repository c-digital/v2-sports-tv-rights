<?php

namespace App\Controllers;

use View;

class LeagueController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('league.index');
    }
}
