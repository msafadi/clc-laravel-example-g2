<?php

use App\Tag;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tag/{id}', function($id) {
    $tag = Tag::findOrFail($id);
    echo $tag->name . "<br><ul>";
    foreach ($tag->products as $product) {
        echo '<li>' . $product->name . '</li>';
    }
    echo '</ul>';
});






Auth::routes([
    //'register' => false,
    'verify' => true, // Verification Email routes
]);

Route::get('/home', 'HomeController@index')
    ->name('home')
    ->middleware('auth', 'verified');
