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
    return view('content/content');
});

// Rutas para categorias
Route::get('/category', 'CategoryController@index');
Route::post('/category/store', 'CategoryController@store');
Route::put('/category/update', 'CategoryController@update');
Route::put('/category/deactivate', 'CategoryController@deactivate');
Route::put('/category/activate', 'CategoryController@activate');
Route::get('/category/selectCategory', 'CategoryController@selectCategory');

// Rutas para articulos
Route::get('/article', 'ArticleController@index');
Route::post('/article/store', 'ArticleController@store');
Route::put('/article/update', 'ArticleController@update');
Route::put('/article/deactivate', 'ArticleController@deactivate');
Route::put('/article/activate', 'ArticleController@activate');
