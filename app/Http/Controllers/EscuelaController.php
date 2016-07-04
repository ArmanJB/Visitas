<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\EscuelaRequest;
use visitas\Escuelas;
use DB;

class EscuelaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }
    
    public function index(){
        return view('escuela.index');
    }

    public function create(){
    	return view('escuela.create');
    }

    public function store(EscuelaRequest $req){
    	if($req->ajax() ){
    		Escuelas::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $escuelas = DB::select('SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS nombreDep FROM escuelas, departamentos WHERE escuelas.id_departamento = departamentos.id');
        //$escuelas = Escuelas::all();
        return response()->json(
            $escuelas
        );
    }

    public function edit($id){
        $escuela = Escuelas::find($id);

        return response()->json(
            $escuela->toArray()
        );
    }

    public function update(Request $req, $id){
        $escuela = Escuelas::find($id);
        $escuela->fill($req->all());
        $escuela->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $escuela = Escuelas::find($id);
        $escuela->delete();

        return response()->json(['mensaje'=>'borrado']);
    }

    public function escuelaByDep($id){
        $escuelas = DB::select('SELECT * FROM escuelas WHERE id_departamento = '.$id);
        return response()->json(
            $escuelas
        );
    }

    public function depByEscuela($id){
        $dep = DB::select('SELECT escuelas.id, departamentos.nombre 
            From escuelas, departamentos 
            WHERE escuelas.id_departamento = departamentos.id 
            AND escuelas.id = '.$id);
        return response()->json(
            $dep
        );
    }

    public function escuelasBySearch($search){
        $escuelas = DB::select('SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS nombreDep FROM escuelas, departamentos WHERE escuelas.id_departamento = departamentos.id AND escuelas.nombre LIKE "%'.$search.'%"');
        return response()->json(
            $escuelas
        ); 
    }
    public function escuelasBySearchDep($id){
        $escuelas = DB::select('SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS nombreDep FROM escuelas, departamentos WHERE escuelas.id_departamento = departamentos.id AND escuelas.id_departamento = '.$id);
        return response()->json(
            $escuelas
        ); 
    }
}
