<?php

namespace App\Http\Controllers;

use App\Models\Categories as Cat;
use Illuminate\Http\Request;

class Categories extends Controller
{
    /*
    *   renders the categories
    */
    public function index()
    {
        // set page in case it's wrong
        $page = empty($_GET['PAGE']) || $_GET['page'] < 1 ? 1 : (int)$_GET['page'];

        // set elem num
        $elems = 20;

        // return
        return view('categories', [
            'DATA'=> Cat::withCount('getEntities')
                        ->offset($elems*$page-$elems)
                        ->paginate(20),
        ]);
    }

    /*
    *   renders a specific category
    */
    public function get($catId)
    {
        return;
    }
}
