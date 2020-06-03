<?php

Route::get('/categories', 'CategoriesController@index')->name('categories'); // admin/categoreis
Route::get('/categories/{id}/childs', 'CategoriesController@index')->name('categories.child');
Route::get('/categories/create', 'CategoriesController@create')->name('categories.create');
Route::post('/categories', 'CategoriesController@store')->name('categories.store');
Route::get('/categories/{id}', 'CategoriesController@edit')->name('categories.edit');
Route::put('/categories/{id}', 'CategoriesController@update')->name('categories.update');
Route::delete('/categories/{id}', 'CategoriesController@delete')->name('categories.delete');

Route::post('products/{id}/restore', 'ProductsController@restore')->name('products.restore');
Route::delete('products/{id}/force-delete', 'ProductsController@forceDelete')->name('products.forceDelete');
Route::resource('products', 'ProductsController')->names([
    //'index' => 'products', // Rename route (products.index) to (products)
    //'destroy' => 'products.delete' // Rename route (products.destory) to (products.delete)
    // others will remain with default names!
]);
// GET /admin/products -> index (products.index)
// GET /admin/products/{product} -> show (products.show)
// GET /admin/products/{product}/edit -> edit (products.edit)
// GET /admin/products/create -> create (products.create)
// POST /admin/products -> store (products.store)
// PUT /admin/products/{product} -> update (products.update)
// DELETE /admin/products/{product} -> destroy (products.destroy)

Route::resource('tags', 'TagsController');

Route::resource('roles', 'RolesController');