<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\DetalleRequest;
use visitas\Detalles;
use DB;

class DetalleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(DetalleRequest $req){
    	if($req->ajax() ){
    		Detalles::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        /*$escuelas = DB::select('SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS nombreDep FROM escuelas, departamentos WHERE escuelas.id_departamento = departamentos.id');
        return response()->json(
            $escuelas
        );*/
    }

    public function edit($id){
        $detalle = Detalles::find($id);

        return response()->json(
            $detalle->toArray()
        );
    }


    public function destroy($id){
        $detalle = Detalles::find($id);
        $detalle->delete();
        return response()->json(['mensaje'=>'borrado']);
    }

    public function detalleByVisita($id){
        $detalles = DB::select('SELECT * FROM detalle_visita WHERE id_visita = '.$id);
        return response()->json(
            $detalles
        );
    }

    public function detallesByVisita($id){
        $detalles = DB::select('SELECT detalle_visita.id, detalle_visita.horas, motivos.nombre, motivos.id_area, detalle_visita.id_motivo
            FROM detalle_visita, motivos 
            WHERE detalle_visita.id_motivo = motivos.id 
            AND id_visita = '.$id);
        return response()->json(
            $detalles
        );
    }
}
