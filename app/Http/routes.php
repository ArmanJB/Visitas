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
Route::get('menu', 'FrontController@menu');
Route::get('admin', 'FrontController@admin');
Route::get('visitaAdmin', 'FrontController@visitaAdmin');
Route::get('visita/charts', 'FrontController@charts');


Route::resource('usuario', 'UsuarioController');
Route::resource('log', 'LogController');
Route::get('logout', 'LogController@logout');

Route::resource('departamento', 'DepartamentoController');
Route::get('departamentos', 'DepartamentoController@listing');

Route::resource('escuela', 'EscuelaController');
Route::get('escuelas', 'EscuelaController@listing');
Route::get('escuela/byDep/{id}', 'EscuelaController@escuelaByDep');
Route::get('escuela/depBy/{id}', 'EscuelaController@depByEscuela');
//Route::get('escuelas/{id}', 'EscuelaController@getEscuelas');

Route::resource('area', 'AreaController');
Route::get('areas', 'AreaController@listing');

Route::resource('oficial', 'OficialController');
Route::get('oficiales', 'OficialController@listing');
Route::get('oficial/byArea/{id}', 'OficialController@oficialByArea');

Route::resource('motivo', 'MotivoController');
Route::get('motivos', 'MotivoController@listing');
Route::get('motivo/byArea/{id}', 'MotivoController@motivoByArea');

Route::resource('pendiente', 'pendienteController');
Route::get('pendientes', 'pendienteController@listing');
Route::get('pendiente/byVisita/{id}', 'pendienteController@pendienteByVisita');
Route::get('pendiente/sbyVisita/{id}', 'pendienteController@pendientesByVisita');

Route::resource('visita', 'VisitaController');
Route::get('visitas', 'VisitaController@listing');

Route::get('visitas/byDep/{ini}/{fin}', 'VisitaController@visitasByDep');
Route::get('visitas/byDepDet/{ini}/{fin}/{idDep}', 'VisitaController@visitasByDepDet');

Route::get('visitas/byArea/{ini}/{fin}', 'VisitaController@visitasByArea');
Route::get('visitas/byAreaDet/{ini}/{fin}/{idArea}', 'VisitaController@visitasByAreaDet');

Route::get('visitas/byEsc/{ini}/{fin}', 'VisitaController@visitasByEsc');
Route::get('visitas/byEscDet/{ini}/{fin}/{idOfi}', 'VisitaController@visitasByEscDet');

Route::get('visitas/byOfi/{ini}/{fin}', 'VisitaController@visitasByOfi');
Route::get('visitas/byOfiDet/{ini}/{fin}/{idOfi}', 'VisitaController@visitasByOfiDet');

Route::get('visitas/byMot/{ini}/{fin}', 'VisitaController@visitasByMot');
Route::get('visitas/byMotDet/{ini}/{fin}/{idArea}', 'VisitaController@visitasByMotDet');

Route::resource('detalle', 'DetalleController');
Route::get('detalles', 'DetalleController@listing');
Route::get('detalle/byVisita/{id}', 'DetalleController@detalleByVisita');
Route::get('detalle/sbyVisita/{id}', 'DetalleController@detallesByVisita');

Route::resource('mobile', 'MobileController');
Route::get('obtener_datos/{user}/{token}', 'MobileController@data');
Route::get('insertar_visita/{fecha}/{id_escuela}/{id_oficial}/{pendiente}/{motivos}', 'MobileController@insert');