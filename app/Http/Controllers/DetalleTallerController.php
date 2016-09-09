<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\DetalleTaller;

class DetalleTallerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Request $req){
    	if($req->ajax() ){
    		$detalle = new DetalleTaller;
	    	$detalle->id_taller = $req->id_taller;
	    	if ($req->data == 'id_escuela') {
	    		$detalle->id_escuela = $req->id;
	    	}elseif ($req->data == 'id_zona') {
	    		$detalle->id_zona = $req->id;
	    	}elseif ($req->data == 'id_internacional') {
	    		$detalle->id_internacional = $req->id;
	    	}
	        $detalle->save();

    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $detalles = DetalleTaller::all();
        return response()->json(
            $detalles->toArray()
        );
    }

    public function edit($id){
        $detalle = DetalleTaller::find($id);

        return response()->json(
            $detalle->toArray()
        );
    }

    public function update(Request $req, $id){
        $detalle = DetalleTaller::find($id);
        $detalle->fill($req->all());
        $detalle->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $detalle = DetalleTaller::find($id);
        $detalle->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
