<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\MetaRequest;
use visitas\Metas;
use DB;

class MetaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }
    
    public function index(){
        //return view('escuela.index');
    }

    public function create(){
    	//return view('escuela.create');
    }

    public function store(MetaRequest $req){
    	if($req->ajax() ){
    		Metas::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $metas = DB::select("SELECT metas.id, metas.id_periodo, periodos.mes, periodos.anio, 
            metas.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS 'oficial', metas.meta 
            FROM metas, periodos, oficiales WHERE metas.id_oficial=oficiales.id AND metas.id_periodo=periodos.id");
        return response()->json(
            $metas
        );
    }

    public function edit($id){
        $meta = Metas::find($id);

        return response()->json(
            $meta->toArray()
        );
    }

    public function update(Request $req, $id){
        $meta = Metas::find($id);
        $meta->fill($req->all());
        $meta->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $meta = Metas::find($id);
        $meta->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
