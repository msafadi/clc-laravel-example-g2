<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('lang')
    ->prefix('{lang?}')
    ->where([
        'lang' => '[a-z]{2}'
    ])->group(function() {
        Auth::routes([
            //'register' => false,
            'verify' => true, // Verification Email routes
        ]);

        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/category/{id}', 'CategoriesController@index')
            ->name('category')
            ->where([
                'id' => '\d+'
            ]);
        Route::get('/product/{id}', 'ProductsController@show')
            ->name('product.details')
            ->where([
                'id' => '\d+'
            ]);

        Route::post('cart', 'CartController@store')->name('cart.store');
        Route::get('cart', 'CartController@index')->name('cart');
        Route::get('cart/remove/{product_id}', 'CartController@remove')->name('cart.remove');
});

Route::get('download/{id}', 'FileController@download');
Route::get('view-file/{id}', 'FileController@view')->name('file');

/*Route::get('/tag/{id}', function($id) {
    $tag = Tag::findOrFail($id);
    echo $tag->name . "<br><ul>";
    foreach ($tag->products as $product) {
        echo '<li>' . $product->name . '</li>';
    }
    echo '</ul>';
});*/

/*Route::get('/home', 'HomeController@index')
    ->name('home')
    ->middleware('auth', 'verified');*/
