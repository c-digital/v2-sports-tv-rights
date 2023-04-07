<?php

namespace App\Controllers;

use View;

class FranciaController extends Controller
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
        return view('francia.liga');
    }
}
