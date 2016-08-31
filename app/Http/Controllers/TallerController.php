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
use visitas\DetalleTaller;

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

    public function infoTaller($id){
        $taller = DB::select("SELECT * FROM talleres WHERE talleres.id = $id");

        $oficiales = DB::select("SELECT taller_oficial.id, taller_oficial.id_oficial
                                FROM taller_oficial WHERE taller_oficial.id_taller = $id");

        $contenidos = DB::select("SELECT taller_contenido.id, taller_contenido.id_contenido
                                FROM taller_contenido  WHERE taller_contenido.id_taller = $id");

        $audiencias = DB::select("SELECT taller_audiencia.id, taller_audiencia.id_audiencia
                                FROM taller_audiencia WHERE taller_audiencia.id_taller = $id");

        $detalles = DB::select("SELECT detalle_taller.id, detalle_taller.id_escuela, escuelas.nombre AS 'escuela', 
                                detalle_taller.id_internacional, internacionales.nombre AS 'internacional', 
                                detalle_taller.id_zona, zonas_receptoras.nombre AS 'zona'
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
        return view('taller.edit', ['taller'=>$taller]);;
    }

    public function update(Request $req, $id){
        $taller = Talleres::find($id);
        $taller->fill([
            'fecha' => $req->fecha, 
            'duracion' => $req->duracion, 
            'cant_mujeres' => $req->cant_mujeres, 
            'cant_hombres' => $req->cant_hombres, 
            'observaciones' => $req->observaciones, 
            'id_lugar' => $req->id_lugar, 
            'id_actividad' => $req->id_actividad, 
            'viaticos' => $req->viaticos
        ]);
        $taller->save();

        foreach ($req->oficialesStatus as $key => $value) {
            if ($value == 'm') {
                $tOficial = TallerOficial::find($req->oficialesReg[$key]);
                $tOficial->fill([
                    'id_taller' => $id, 
                    'id_oficial' => $req->oficiales[$key]
                ]);
                $tOficial->save();
            }elseif ($value == 'n') {
                $tOficial = new TallerOficial;
                $tOficial->id_taller = $id;
                $tOficial->id_oficial = $req->oficiales[$key];
                $tOficial->save();
            }elseif ($value == 'd') {
                $tOficial = TallerOficial::find($req->oficialesReg[$key]);
                $tOficial->delete();
            }
        }

        foreach ($req->contenidosStatus as $key => $value) {
            if ($value == 'm') {
                $tContenido = TallerContenido::find($req->contenidosReg[$key]);
                $tContenido->fill([
                    'id_taller' => $id, 
                    'id_contenido' => $req->contenidos[$key]
                ]);
                $tContenido->save();
            }elseif ($value == 'n') {
                $tContenido = new TallerContenido;
                $tContenido->id_taller = $id;
                $tContenido->id_contenido = $req->contenidos[$key];
                $tContenido->save();
            }elseif ($value == 'd') {
                $tContenido = TallerContenido::find($req->contenidosReg[$key]);
                $tContenido->delete();
            }
        }

        foreach ($req->audienciasStatus as $key => $value) {
            if ($value == 'm') {
                $tAudiencia = TallerAudiencia::find($req->audienciasReg[$key]);
                $tAudiencia->fill([
                    'id_taller' => $id, 
                    'id_audiencia' => $req->audiencias[$key]
                ]);
                $tAudiencia->save();
            }elseif ($value == 'n') {
                $tAudiencia = new TallerAudiencia;
                $tAudiencia->id_taller = $id;
                $tAudiencia->id_audiencia = $req->audiencias[$key];
                $tAudiencia->save();
            }elseif ($value == 'd') {
                $tAudiencia = TallerAudiencia::find($req->audienciasReg[$key]);
                $tAudiencia->delete();
            }
        }
        //DETALLE_TALLER
        foreach ($req->detallesStatus as $key => $value) {
            if ($value == 'm') {
                $dTaller = DetalleTaller::find($req->detallesReg[$key]);
                if ($req->detallesData[$key] == 'id_escuela') {
                    $dTaller->fill(['id_taller' => $id, 'id_escuela' => $req->detalles[$key] ]);
                }elseif ($req->detallesData[$key] == 'id_internacional') {
                    $dTaller->fill(['id_taller' => $id, 'id_internacional' => $req->detalles[$key] ]);
                }elseif ($req->detallesData[$key] == 'id_zona') {
                    $dTaller->fill(['id_taller' => $id, 'id_zona' => $req->detalles[$key] ]);
                }
                $dTaller->save();
            }elseif ($value == 'n') {
                $dTaller = new DetalleTaller;
                if ($req->detallesData[$key] == 'id_escuela') {
                    $dTaller->id_taller = $id; 
                    $dTaller->id_escuela = $req->detalles[$key];
                }elseif ($req->detallesData[$key] == 'id_internacional') {
                    $dTaller->id_taller = $id; 
                    $dTaller->id_internacional = $req->detalles[$key];
                }elseif ($req->detallesData[$key] == 'id_zona') {
                    $dTaller->id_taller = $id;
                    $dTaller->id_zona = $req->detalles[$key];
                }
                $dTaller->save();
            }elseif ($value == 'd') {
                 $dTaller = DetalleTaller::find($req->detallesReg[$key]) ;
                 $dTaller->delete();
            }
        }

        return response()->json([
            'mensaje' => 'Registros actualizados'
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
