<?php

namespace App\Controllers;

use View;

class EuropaController extends Controller
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
     * Handle the incoming request.
     */
    public function champions(): View
    {
        return view('europa.champions');
    }
    
    /**
     * Handle the incoming request.
     */
    public function europa(): View
    {
        return view('europa.europa');
    }
}
