<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\UserCreateRequest;
use visitas\Http\Requests\UserUpdateRequest;
use Session;
use Redirect;
use Auth;
use visitas\User;

class UsuarioController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('admin');
		//$this->middleware('admin', ['only' => ['create', 'edit']]);
	}

	public function index(){
		$users = User::paginate(8);
		return view('usuario.index', compact('users'));
	}

	public function create(){
		return view('usuario.create');
	}

	public function store(UserCreateRequest $req){
		User::create($req->all());
		/*User::create([
			'name' => $req['name'],
			'email' => $req['email'],
			'password' => $req['password'],
			]);*/
		Session::flash('message', 'Usuario Agregado Existosamete!');
		return Redirect::to('/usuario');
	}

	public function edit($id){
		$user = User::find($id);
		return view('usuario.edit', ['user'=>$user]);
	}

	public function update($id, UserUpdateRequest $req){
		$user = User::find($id);
		$user->fill($req->all());
		$user->save();

		Session::flash('message', 'Usuario Editado Existosamete!');
		return Redirect('/usuario');
	}

	public function destroy($id){
		User::destroy($id);
		Session::flash('message', 'Usuario Eliminado Existosamete!');
		return Redirect('/usuario');
	}
}
