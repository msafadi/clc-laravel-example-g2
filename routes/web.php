<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::namesapce('Admin')->prefix('admin')->group(function() {
    Route::get('/categories', 'CategoriesController@index'); // admin/categoreis
    Route::get('/categoreis/create', 'CategoriesController@create');
    Route::post('/categoreis', '\CategoriesController@store');
    Route::get('/categoreis/{id}', 'CategoriesController@edit');
    Route::put('/categoreis/{id}', 'CategoriesController@update');
    Route::delete('/categories/{id}', 'CategoriesController@delete');

    Route::get('/products', 'ProductsController@index');
    Route::get('/products/create', 'ProductsController@create');
    Route::post('/products', 'ProductsController@store');
    Route::get('/products/{id}', 'ProductsController@edit');
    Route::put('/products/{id}', 'ProductsController@update');
    Route::delete('/products/{id}', 'ProductsController@delete');
});





