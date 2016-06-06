<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {return view('index');});
Route::get('/', 'FrontController@index');
Route::get('admin', 'FrontController@admin');


Route::resource('usuario', 'UsuarioController');
Route::resource('departamento', 'DepartamentoController');
Route::get('departamentos', 'DepartamentoController@listing');


Route::resource('log', 'LogController');
Route::get('logout', 'LogController@logout');