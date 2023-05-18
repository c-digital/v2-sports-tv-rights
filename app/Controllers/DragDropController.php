<?php

namespace App\Controllers;

use View;

class DragDropController extends Controller
{
	public function __construct()
    {
        $this->middleware('Auth');
    }

    public function index(): View
    {
    	return view('drag-drop.index');
    }
}
