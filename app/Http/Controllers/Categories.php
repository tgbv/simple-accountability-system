<?php

namespace App\Http\Controllers;

use App\Models\Categories as Cat;
use Illuminate\Http\Request;
use App\Http\Requests\ApiNewCategory;
use App\Http\Requests\ApiPushSubcategories;

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
                        ->with('getChilds')
                        ->whereDoesntHave('getParent')
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

    /*
    *   retrieves all categories
        API dedicated
    */
    public function apiGetAll()
    {
        return response(
            Cat::select('id', 'name')
                ->orderBy('name')
                ->get()
        );
    }

    /*
    *   creates category
        API dedicated
    */
    public function apiPost(ApiNewCategory $request)
    {
        return response(
            Cat::create( $request->post() )
        );
    }

    /*
    *   pushes new subcategories to category
    */
    public function apiPushSubcat($parentId, ApiPushSubcategories $Request)
    {
        // make sure parentId exists
        Cat::findOrFail($parentId, ['id']);

        // due to laravel limiting me to 'attach' an existing record to a 'hasMany' relationship
        // i've decided to modify the tables directly.
        // i don't like it but it works.
        Cat::whereIn('id', $Request->input('categories'))
            ->update([
                'parent_of' => $parentId
            ]);

        // done
        return response([]);
    }
}
