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

    public function detail($id){
        $taller = DB::select("SELECT talleres.fecha, talleres.duracion, talleres.cant_mujeres, talleres.cant_hombres, 
                                lugares.nombre AS 'lugar', actividades.nombre AS 'actividad', 
                                talleres.viaticos, talleres.observaciones
                                FROM talleres 
                                INNER JOIN lugares ON talleres.id_lugar = lugares.id 
                                INNER JOIN actividades ON talleres.id_actividad = actividades.id
                                WHERE talleres.id = $id");

        $oficiales = DB::select("SELECT taller_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS 'oficial'
                                FROM taller_oficial INNER JOIN oficiales ON taller_oficial.id_oficial=oficiales.id
                                WHERE taller_oficial.id_taller = $id");

        $contenidos = DB::select("SELECT taller_contenido.id_contenido, contenidos.nombre as 'contenido'
                                FROM taller_contenido INNER JOIN contenidos ON taller_contenido.id_contenido=contenidos.id
                                WHERE taller_contenido.id_taller = $id");

        $audiencias = DB::select("SELECT taller_audiencia.id_audiencia, audiencia.nombre AS 'audiencia'
                                FROM taller_audiencia INNER JOIN audiencia ON taller_audiencia.id_audiencia=audiencia.id
                                WHERE taller_audiencia.id_taller = $id");

        $detalles = DB::select("SELECT detalle_taller.id, escuelas.nombre AS 'escuela', 
                                internacionales.nombre AS 'pais', zonas_receptoras.nombre AS 'zona'
                                FROM detalle_taller LEFT JOIN escuelas ON detalle_taller.id_escuela=escuelas.id
                                LEFT JOIN internacionales ON detalle_taller.id_internacional=internacionales.id
                                LEFT JOIN zonas_receptoras ON detalle_taller.id_zona=zonas_receptoras.id
                                WHERE detalle_taller.id_taller = $id");

        return response()->json([
            'taller'=>$taller, 
            'oficiales'=>$oficiales, 
            'contenidos'=>$contenidos, 
            'audiencias'=>$audiencias,
            'detalles'=>$detalles
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
        DB::table('detalle_taller')->where('id_taller','=',$id)->delete();
        DB::table('taller_audiencia')->where('id_taller','=',$id)->delete();
        DB::table('taller_contenido')->where('id_taller','=',$id)->delete();
        DB::table('taller_oficial')->where('id_taller','=',$id)->delete();

        $taller = Talleres::find($id);
        $taller->delete();

        return response()->json(['mensaje'=>'registros eliminados']);
    }
}
