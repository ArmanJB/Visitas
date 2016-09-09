<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\VoluntarioRequest;
use visitas\Voluntarios;
use DB;

class VoluntarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }
    
    public function index(){
        return view('voluntario.index');
    }

    public function create(){
    	return view('voluntario.create');
    }

    public function store(VoluntarioRequest $req){
    	if($req->ajax() ){
    		Voluntarios::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $voluntarios = Voluntarios::all();
        return response()->json(
            $voluntarios->toArray()
        );
    }

    public function edit($id){
        $voluntario = Voluntarios::find($id);

        return response()->json(
            $voluntario->toArray()
        );
    }

    public function update(Request $req, $id){
        $voluntario = Voluntarios::find($id);
        $voluntario->fill($req->all());
        $voluntario->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $voluntario = Voluntarios::find($id);
        $voluntario->delete();

        return response()->json(['mensaje'=>'borrado']);
    }

}
