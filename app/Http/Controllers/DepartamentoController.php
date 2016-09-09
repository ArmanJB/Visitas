<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\DepartamentoRequest;
use visitas\Departamentos;

class DepartamentoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('departamento.index');
    }

    public function create(){
    	return view('departamento.create');
    }

    public function store(DepartamentoRequest $req){
    	if($req->ajax() ){
    		Departamentos::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $departamentos = Departamentos::all();
        return response()->json(
            $departamentos->toArray()
        );
    }

    public function edit($id){
        $departamento = Departamentos::find($id);

        return response()->json(
            $departamento->toArray()
        );
    }

    public function update(Request $req, $id){
        $departamento = Departamentos::find($id);
        $departamento->fill($req->all());
        $departamento->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $departamento = Departamentos::find($id);
        $departamento->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
