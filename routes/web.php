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
// Route::name('entities')->get('/entities', );
