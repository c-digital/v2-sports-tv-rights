<?php

namespace App\Controllers;

use View;

class BoliviaController extends Controller
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
        return view('bolivia.liga');
    }
    
    /**
     * Handle the incoming request.
     */
    public function copa(): View
    {
        return view('bolivia.copa');
    }
}
