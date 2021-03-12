<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    /*
    *   returns to the homepage
    */
    public function index()
    {
        return view('home');
    }
}
