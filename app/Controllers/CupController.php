<?php

namespace App\Controllers;

use View;

class CupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('cup.index');
    }
}
