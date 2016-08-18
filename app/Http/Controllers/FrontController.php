<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;

class FrontController extends Controller
{
	public function __construct(){
		$this->middleware('auth', ['only' => ['admin', 'menu', 'visitaAdmin', 'charts']]);
		$this->middleware('admin', ['only' => ['admin', 'menu']]);
	}

    public function index(){
    	return view('index');
    }

    public function admin(){
    	return view('layouts.admin');
    }

    public function visitaAdmin(){
        return view('layouts.visitaAdmin');
    }

    public function menu(){
    	return view('menu');
    }

    public function charts(){
        return view('visita.charts');
    }

    public function informe(){
        return view('visita.informe');
    }

    /***************Nuevos*********************/

    public function catalogos(){
        return view('catalogos.catalogos1');
    }

    public function personas(){
        return view('planificacion.personas.personas');
    }

    public function escuelas(){
        return view('planificacion.escuelas.escuelas');
    }

    public function metas(){
        return view('planificacion.metas.metas');
    }

    public function motivos(){
        return view('planificacion.motivos.motivos');
    }
}
