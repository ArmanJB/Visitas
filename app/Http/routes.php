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
Route::resource('log', 'LogController');
Route::get('logout', 'LogController@logout');

Route::resource('departamento', 'DepartamentoController');
Route::get('departamentos', 'DepartamentoController@listing');

Route::resource('escuela', 'EscuelaController');
Route::get('escuelas', 'EscuelaController@listing');
//Route::get('escuelas/{id}', 'EscuelaController@getEscuelas');

Route::resource('area', 'AreaController');
Route::get('areas', 'AreaController@listing');

Route::resource('oficial', 'OficialController');
Route::get('oficiales', 'OficialController@listing');

Route::resource('motivo', 'MotivoController');
Route::get('motivos', 'MotivoController@listing');
