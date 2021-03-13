<?php

use Illuminate\Support\Facades\Route;


Route::name('home')->get('/', 'Home@index');

/*
*   CATEGORIES
*/
Route::prefix('categories')->group(function()
{
    # api-related
    Route::name('categories.api-all')->get('/api-all', 'Categories@apiGetAll');
    Route::name('categories.api-post')->post('/api', 'Categories@apiPost');
    Route::name('categories.api-pushSubcat.parent_id')->patch('/api-pushSubcat/{parent_id}', 'Categories@apiPushSubcat');

    # ..not api-related
    Route::name('categories')->get('/', 'Categories@index');
    Route::name('categories.id')->get('/{id}', 'Categories@get');

});

/*
*   ENTITIES
*/
Route::prefix('entities')->group(function()
{
    # api-related
    Route::name('entities.api-paginateAll')->get('/api-paginateAll', 'Entities@apiPaginateAll');
    Route::name('entities.entity_id.api-pushCat')->patch('/{entity_id}/api-pushCat', 'Entities@apiPushCat');

    # ..not api-related
    Route::name('entities')->get('/', 'Entities@index');
    //Route::name('entities.id')->get('/{id}', 'Entities@get');

});
// Route::name('entities')->get('/entities', );
