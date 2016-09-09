<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\ActividadRequest;
use visitas\Actividades;

class ActividadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('actividad.index');
    }

    public function create(){
    	return view('actividad.create');
    }

    public function store(ActividadRequest $req){
    	if($req->ajax() ){
    		Actividades::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $actividades = Actividades::all();
        return response()->json(
            $actividades->toArray()
        );
    }

    public function edit($id){
        $actividad = Actividades::find($id);

        return response()->json(
            $actividad->toArray()
        );
    }

    public function update(Request $req, $id){
        $actividad = Actividades::find($id);
        $actividad->fill($req->all());
        $actividad->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $actividad = Actividades::find($id);
        $actividad->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
