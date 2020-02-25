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


Route::namespace('Admin')->prefix('admin')->group(function() {
    Route::get('/categories', 'CategoriesController@index')->name('categories'); // admin/categoreis
    Route::get('/categories/create', 'CategoriesController@create')->name('categories.create');
    Route::post('/categories', 'CategoriesController@store')->name('categories.store');
    Route::get('/categories/{id}', 'CategoriesController@edit')->name('categories.edit');
    Route::put('/categories/{id}', 'CategoriesController@update')->name('categories.update');
    Route::delete('/categories/{id}', 'CategoriesController@delete')->name('categories.delete');

    Route::get('/products', 'ProductsController@index');
    Route::get('/products/create', 'ProductsController@create');
    Route::post('/products', 'ProductsController@store');
    Route::get('/products/{id}', 'ProductsController@edit');
    Route::put('/products/{id}', 'ProductsController@update');
    Route::delete('/products/{id}', 'ProductsController@delete');
});





