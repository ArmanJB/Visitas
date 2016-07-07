<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\OficialRequest;
use visitas\Oficiales;
use DB;

class OficialController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }
    
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
        $oficiales = DB::select('SELECT oficiales.id, oficiales.nombres, oficiales.apellidos, areas.nombre, oficiales.meta, oficiales.id_area FROM oficiales, areas WHERE oficiales.id_area = areas.id');
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

    public function oficialByArea($id){
        $oficiales = DB::select('SELECT * FROM oficiales WHERE id_area = '.$id);
        return response()->json(
            $oficiales
        );
    }

    public function areaByName($name){
        $oficial = DB::select("SELECT * FROM (SELECT oficiales.id_area, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre 
            FROM oficiales) AS consulta WHERE consulta.nombre = '$name' 
            GROUP BY consulta.id_area");
        return response()->json(
            $oficial
        );
    }
}
