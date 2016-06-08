<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;

class FrontController extends Controller
{
	public function __construct(){
		$this->middleware('auth', ['only' => ['admin', 'menu', 'visitaAdmin']]);
		//$this->middleware('auth', ['only' => 'admin']);
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
}
