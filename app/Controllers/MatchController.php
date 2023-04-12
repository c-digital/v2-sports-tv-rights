<?php

namespace App\Controllers;

use View;

class MatchController extends Controller
{
    /**
     * Verify if user is logged.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('Auth');
    }

    /**
     * Summary page.
     */
    public function summary(): View
    {
        return view('matches.summary');
    }

    /**
     * Lineups page.
     */
    public function lineups(): View
    {
        return view('matches.lineups');
    }

    /**
     * Stats page.
     */
    public function stats(): View
    {
        return view('matches.stats');
    }

    /**
     * Heat map page.
     */
    public function heatMap(): View
    {
        return view('matches.heat-map');
    }

    /**
     * Standing page.
     */
    public function standings(): View
    {
        return view('matches.standings');
    }

    /**
     * Replay page.
     */
    public function replay(): View
    {
        return view('matches.replay');
    }

    /**
     * Dynamic page.
     */
    public function dynamic(): View
    {
        return view('matches.dynamic');
    }
}
