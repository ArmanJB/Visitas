<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\PendienteRequest;
use visitas\Pendientes;
use DB;

class pendienteController extends Controller
{
    public function index(){
        return view('pendiente.index');
    }

    public function create(){
    	return view('pendiente.create');
    }

    public function store(PendienteRequest $req){
    	if($req->ajax() ){
    		Pendientes::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $pendientes = Pendientes::all();
        return response()->json(
            $pendientes->toArray()
        );
    }

    public function edit($id){
        $pendientes = Pendientes::find($id);

        return response()->json(
            $pendientes->toArray()
        );
    }

    public function update(Request $req, $id){
        $pendiente = Pendientes::find($id);
        $pendiente->fill($req->all());
        $pendiente->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $pendiente = Pendientes::find($id);
        $pendiente->delete();

        return response()->json(['mensaje'=>'borrado']);
    }

    public function pendienteByVisita($id){
        $pendiente = DB::select('SELECT * FROM pendientes WHERE id_visita = '.$id);
        return response()->json(
            $pendiente
        );
    }
    public function pendientesByVisita($id){
        $pendiente = DB::select('SELECT * FROM pendientes WHERE pendientes.id_visita = '.$id);
        return response()->json(
            $pendiente
        );
    }

}
