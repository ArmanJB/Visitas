<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

use visitas\Http\Requests;
use visitas\Http\Requests\LoginRequest;

class LogController extends Controller
{
    public function store(LoginRequest $req){
    	if (Auth::attempt(['email'=>$req['email'], 'password'=>$req['password']])) {
    		//return Redirect::to('/usuario');
            return Redirect::to('/menu');
    	}
    	Session::flash('message-error', 'Datos son incorrectos');
    	return Redirect::to('/');
    }

    public function logout(){
    	Auth::logout();
    	return Redirect::to('/');
    }
}
