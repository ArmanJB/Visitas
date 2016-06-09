<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\MotivoRequest;
use visitas\Motivos;
use DB;

class MotivoController extends Controller
{
    public function index(){
        return view('motivo.index');
    }

    public function create(){
    	return view('motivo.create');
    }

    public function store(MotivoRequest $req){
    	if($req->ajax() ){
    		Motivos::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $motivos = DB::select('SELECT motivos.id, motivos.nombre, areas.nombre AS nombreAr FROM motivos, areas WHERE motivos.id_area = areas.id');
        //$motivos = Escuelas::all();
        return response()->json(
            $motivos
        );
    }

    public function edit($id){
        $motivo = Motivos::find($id);

        return response()->json(
            $motivo->toArray()
        );
    }

    public function update(Request $req, $id){
        $motivo = Motivos::find($id);
        $motivo->fill($req->all());
        $motivo->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $motivo = Motivos::find($id);
        $motivo->delete();

        return response()->json(['mensaje'=>'borrado']);
    }

    public function motivoByArea($id){
        $motivos = DB::select('SELECT * FROM motivos WHERE id_area = '.$id);
        return response()->json(
            $motivos
        );
    }
}
