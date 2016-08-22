<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\TallerRequest;
use visitas\Talleres;
use DB;

use visitas\TallerAudiencia;
use visitas\TallerContenido;
use visitas\TallerOficial;

class TallerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        return view('taller.index');
    }

    public function create(){
    	return view('taller.create');
    }

    public function store(TallerRequest $req){
    	if($req->ajax() ){
    		Talleres::create($req->all());
            $aux = Talleres::all();
            $taller = $aux->last();

            foreach ($req->oficiales as $key => $value) {
                $tOficial = new TallerOficial;
                $tOficial->id_taller = $taller->id;
                $tOficial->id_oficial = $value;
                $tOficial->save();
            }

            foreach ($req->contenidos as $key => $value) {
                $tContenidos = new TallerContenido;
                $tContenidos->id_taller = $taller->id;
                $tContenidos->id_contenido = $value;
                $tContenidos->save();
            }

            foreach ($req->audiencias as $key => $value) {
                $tAudiencia = new TallerAudiencia;
                $tAudiencia->id_taller = $taller->id;
                $tAudiencia->id_audiencia = $value;
                $tAudiencia->save();
            }

    		return response()->json([
    			'resp' => $taller->id
    		]);
    	}
    }

    public function listing(){
        $talleresGroup = DB::select('SELECT talleres.id, talleres.fecha, actividades.nombre, oficiales.nombres, oficiales.apellidos
                                FROM talleres 
                                RIGHT JOIN actividades ON talleres.id_actividad=actividades.id
                                RIGHT JOIN taller_oficial ON talleres.id=taller_oficial.id_taller
                                LEFT JOIN oficiales ON taller_oficial.id_oficial=oficiales.id
                                GROUP BY talleres.id');


        $talleres = DB::select('SELECT talleres.id, talleres.fecha, actividades.nombre, oficiales.nombres, oficiales.apellidos
                                FROM talleres 
                                RIGHT JOIN actividades ON talleres.id_actividad=actividades.id
                                RIGHT JOIN taller_oficial ON talleres.id=taller_oficial.id_taller
                                LEFT JOIN oficiales ON taller_oficial.id_oficial=oficiales.id');

        return response()->json([
            'group'=>$talleresGroup, 'taller'=>$talleres
        ]);
    }

    public function edit($id){
        $taller = Talleres::find($id);

        return response()->json(
            $taller->toArray()
        );
    }

    public function update(Request $req, $id){
        $taller = Talleres::find($id);
        $taller->fill($req->all());
        $taller->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $taller = Talleres::find($id);
        $taller->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
