<?php

use Illuminate\Support\Facades\Route;


Route::name('home')->get('/', 'Home@index');

/*
*   CATEGORIES
*/
Route::prefix('categories')->group(function()
{
    Route::name('categories')->get('/', 'Categories@index');
    Route::name('categories.id')->get('/{id}', 'Categories@get');


});
// Route::name('entities')->get('/entities', );
