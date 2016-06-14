<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\VisitaRequest;
use visitas\Visitas;
use DB;

class VisitaController extends Controller
{
    public function __construct(){
        //$this->middleware('auth', ['only' => ['admin', 'menu', 'visitaAdmin']]);
        $this->middleware('auth');
    }

    public function index(){
        return view('visita.index');
    }

    public function create(){
    	return view('visita.create');
    }

    public function store(VisitaRequest $req){
    	if($req->ajax() ){
    		Visitas::create($req->all());
            $user = Visitas::all();
            $visita = $user->last();
    		return response()->json([
    			'resp' => $visita->id
    		]);
    	}
    }

    public function listing(){
        $visitas = DB::select("SELECT visitas.id, visitas.fecha, 
            escuelas.nombre AS escuela, departamentos.nombre AS dep, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial 
            FROM visitas, escuelas, oficiales, departamentos 
            WHERE visitas.id_escuela = escuelas.id
            AND escuelas.id_departamento = departamentos.id
            AND visitas.id_oficial = oficiales.id");
        //$visitas = Escuelas::all();
        return response()->json(
            $visitas
        );
    }

    public function edit($id){
        $visita = Visitas::find($id);

        return response()->json(
            $visita->toArray()
        );
    }

    public function update(Request $req, $id){
        $visita = Visitas::find($id);
        $visita->fill($req->all());
        $visita->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $visita = Visitas::find($id);
        $visita->delete();

        return response()->json(['mensaje'=>'borrado']);
    }

}
