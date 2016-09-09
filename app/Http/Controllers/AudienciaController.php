<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\AudienciaRequest;
use visitas\Audiencias;

class AudienciaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('audiencia.index');
    }

    public function create(){
    	return view('audiencia.create');
    }

    public function store(AudienciaRequest $req){
    	if($req->ajax() ){
    		Audiencias::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $audiencia = Audiencias::all();
        return response()->json(
            $audiencia->toArray()
        );
    }

    public function edit($id){
        $audiencia = Audiencias::find($id);

        return response()->json(
            $audiencia->toArray()
        );
    }

    public function update(Request $req, $id){
        $audiencia = Audiencias::find($id);
        $audiencia->fill($req->all());
        $audiencia->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $audiencia = Audiencias::find($id);
        $audiencia->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
