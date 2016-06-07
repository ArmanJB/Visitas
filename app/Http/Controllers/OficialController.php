<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\OficialRequest;
use visitas\Oficiales;
use DB;

class OficialController extends Controller
{
    public function index(){
        return view('oficial.index');
    }

    public function create(){
    	return view('oficial.create');
    }

    public function store(OficialRequest $req){
    	if($req->ajax() ){
    		Oficiales::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $oficiales = DB::select('SELECT oficiales.id, oficiales.nombres, oficiales.apellidos, areas.nombre FROM oficiales, areas WHERE oficiales.id_area = areas.id');
        //$oficiales = Escuelas::all();
        return response()->json(
            $oficiales
        );
    }

    public function edit($id){
        $oficial = Oficiales::find($id);

        return response()->json(
            $oficial->toArray()
        );
    }

    public function update(Request $req, $id){
        $oficial = Oficiales::find($id);
        $oficial->fill($req->all());
        $oficial->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $oficial = Oficiales::find($id);
        $oficial->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
