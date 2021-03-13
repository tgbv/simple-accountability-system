<?php

namespace App\Http\Controllers;

use App\Models\Entities as EntitiesModel;
use App\Http\Requests\ApiPushCategoriesForEntity;
use Illuminate\Http\Request;

class Entities extends Controller
{
    /*
    *   show all entities
    */
    public function index()
    {
        // set page
        $page = empty($_GET['page']) || $_GET['page'] < 1 ? 1 : (int)$_GET['page'];

        // elems per chunk
        $elems = 20;

        // return
        return view('entities', [
            'DATA' => EntitiesModel::with('getCategories')
                                ->offset($page*$elems-$elems)
                                ->paginate($elems)
        ]);
    }

    /*
    *   paginates all entities
        API dedicated
    */
    public function apiPaginateAll()
    {
        // set page
        $page = empty($_GET['page']) || $_GET['page'] < 1 ? 1 : (int)$_GET['page'];

        // elems per chunk
        $elems = 20;

        // return
        return response(
            EntitiesModel::with(['getCategories'=>function($q){
                            $q->orderBy('name');
                        }])
                        ->offset($page*$elems-$elems)
                        ->paginate($elems)
        );
    }

    /*
    *   pushes category to entity
        API dedicated only
    */
    public function apiPushCat($entityId, ApiPushCategoriesForEntity $Request)
    {
        return response(
            EntitiesModel::findOrFail($entityId)
                        ->getCategories()
                        ->attach( $Request->input('categories') )
        );
    }
}
