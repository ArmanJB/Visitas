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
Route::get('visita/informe', 'FrontController@informe');
Route::get('catalogos', 'FrontController@catalogos');
Route::get('personas', 'FrontController@personas');
Route::get('escuelasF', 'FrontController@escuelas');
Route::get('metasF', 'FrontController@metas');
Route::get('motivosF', 'FrontController@motivos');


Route::resource('log', 'LogController');
Route::get('logout', 'LogController@logout');

Route::resource('usuario', 'UsuarioController');
Route::get('usuarios', 'UsuarioController@listing');
Route::get('usuarios/bySearch/{search}', 'UsuarioController@usersBySearch');
Route::get('types', 'UsuarioController@types');
Route::get('usuarios/detalle/{id}', 'UsuarioController@detalle');

Route::resource('departamento', 'DepartamentoController');
Route::get('departamentos', 'DepartamentoController@listing');

Route::resource('escuela', 'EscuelaController');
Route::get('escuelas', 'EscuelaController@listing');
Route::get('escuela/byDep/{id}', 'EscuelaController@escuelaByDep');
Route::get('escuela/depBy/{id}', 'EscuelaController@depByEscuela');
Route::get('escuelas/bySearch/{search}', 'EscuelaController@escuelasBySearch');
Route::get('escuelas/bySearchDep/{id}', 'EscuelaController@escuelasBySearchDep');

Route::resource('area', 'AreaController');
Route::get('areas', 'AreaController@listing');

Route::resource('oficial', 'OficialController');
Route::get('oficials', 'OficialController@listing');
Route::get('oficial/byArea/{id}', 'OficialController@oficialByArea');
Route::get('oficial/byName/{name}', 'OficialController@areaByName');

Route::resource('motivo', 'MotivoController');
Route::get('motivos', 'MotivoController@listing');
Route::get('motivos/bySearch/{search}', 'MotivoController@motivosBySearch');
Route::get('motivo/byArea/{id}', 'MotivoController@motivoByArea');

Route::resource('pendiente', 'pendienteController');
Route::get('pendientes', 'pendienteController@listing');
Route::get('pendiente/byVisita/{id}', 'pendienteController@pendienteByVisita');
Route::get('pendiente/sbyVisita/{id}', 'pendienteController@pendientesByVisita');

Route::resource('visita', 'VisitaController');
Route::get('visitas', 'VisitaController@listing');
Route::get('visitas/c/{area}', 'VisitaController@listingC');
Route::get('visitas/o/{oficial}', 'VisitaController@listingO');
Route::get('visita/detail/{id}', 'VisitaController@detail');
Route::get('visita/infoVisita/{id}', 'VisitaController@infoVisita');
Route::get('charts', 'VisitaController@charts');

Route::get('visitasU/{name}', 'VisitaController@listingU');

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


Route::get('visitas/listingOfi/{idOfi}', 'VisitaController@listingByOfi');
Route::get('visitas/listingEsc/{idEsc}', 'VisitaController@listingByEsc');
Route::get('visitas/listingDate/{date}', 'VisitaController@listingByDate');
Route::get('visitas/listingArea/{idAr}', 'VisitaController@listingByArea');

Route::get('usuario/upd/{id}/{name}/{email}/{pass}', 'UsuarioController@updateU');
Route::get('usuario/correct/{id}', 'UsuarioController@correct');

//*******USUARIOS-CHART************
//Visitas
Route::get('charts/areas/{desde}/{hasta}', 'InformeController@resumenArea');
Route::get('charts/departamentos/{desde}/{hasta}', 'InformeController@resumenDep');
Route::get('charts/coordinador/{desde}/{hasta}/{area}', 'InformeController@resumenCoordinador');
Route::get('charts/oficial/{desde}/{hasta}/{oficial}', 'InformeController@resumenOficial');
//Talleres
Route::get('charts/talleres/{desde}/{hasta}', 'InformeController@resumenTaller');

Route::get('visitas/byDepU/{ini}/{fin}/{area}', 'VisitaController@visitasByDepU');
Route::get('visitas/byDepDetU/{ini}/{fin}/{idDep}/{area}', 'VisitaController@visitasByDepDetU');

Route::get('visitas/byEscU/{ini}/{fin}/{area}', 'VisitaController@visitasByEscU');
Route::get('visitas/byEscDetU/{ini}/{fin}/{idOfi}/{area}', 'VisitaController@visitasByEscDetU');

Route::get('visitas/byOfiU/{ini}/{fin}/{area}', 'VisitaController@visitasByOfiU');
Route::get('visitas/byOfiDetU/{ini}/{fin}/{idOfi}/{area}', 'VisitaController@visitasByOfiDetU');

/***************Informes*********************/
//Visitas
Route::get('visitas/cantArea/{idArea}', 'VisitaController@cantByArea');
Route::get('visitas/cant', 'VisitaController@cant');
Route::get('visitas/cantDet/{idArea}', 'VisitaController@cantDetByArea');
Route::get('visitas/cantOfi/{idArea}', 'VisitaController@cantOfiByArea');
Route::get('visitas/cantEsc/{idArea}', 'VisitaController@cantEscByArea');
//Talleres

/***************Nuevos*********************/
Route::resource('contenido', 'ContenidoController');
Route::get('contenidos', 'ContenidoController@listing');

Route::resource('audiencia', 'AudienciaController');
Route::get('audiencias', 'AudienciaController@listing');

Route::resource('lugar', 'LugarController');
Route::get('lugars', 'LugarController@listing');

Route::resource('actividad', 'ActividadController');
Route::get('actividads', 'ActividadController@listing');

Route::resource('internacional', 'InternacionalController');
Route::get('internacionals', 'InternacionalController@listing');

Route::resource('zonareceptora', 'ZonareceptoraController');
Route::get('zonareceptoras', 'ZonareceptoraController@listing');

Route::resource('voluntario', 'VoluntarioController');
Route::get('voluntarios', 'VoluntarioController@listing');

Route::resource('periodo', 'PeriodoController');
Route::get('periodos', 'PeriodoController@listing');

Route::resource('meta', 'MetaController');
Route::get('metas', 'MetaController@listing');

Route::resource('taller', 'TallerController');
Route::get('talleres', 'TallerController@listing');
Route::get('taller/detail/{id}', 'TallerController@detail');
Route::get('taller/infoTaller/{id}', 'TallerController@infoTaller');
Route::get('chartsT', 'TallerController@charts');

Route::resource('detalleTaller', 'DetalleTallerController');
Route::get('detallesTaller', 'DetalleTallerController@listing');