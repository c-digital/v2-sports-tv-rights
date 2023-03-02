<?php

namespace App\Controllers;

use View;

class EspañaController extends Controller
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
    public function liga(): View
    {
        return view('españa.liga');
    }
    
    /**
     * Handle the incoming request.
     */
    public function copa(): View
    {
        return view('españa.copa');
    }
}
