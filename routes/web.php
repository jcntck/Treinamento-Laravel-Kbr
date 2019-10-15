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
Route::get('/', 'UsuarioController@index');

Route::resource('users', 'UsuarioController');
Route::get('users/notificar/{user}', 'UsuarioController@notificar');
Route::resource('categories', 'CategoriaController');
// Route::any('search', 'UsuarioController@search');
