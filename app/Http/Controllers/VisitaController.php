<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\VisitaRequest;
use visitas\Visitas;
use DB;
use Carbon\Carbon;

use visitas\VisitaOficial;
use visitas\VisitaMotivo;
use visitas\VisitaVoluntario;

class VisitaController extends Controller
{
    public function __construct(){
        $this->middleware('admin', ['only' => ['edit', 'update', 'destroy']]);
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
            $visita = DB::select("SELECT * FROM visitas WHERE visitas.fecha = '$req->fecha' AND visitas.id_escuela = '$req->id_escuela'");

            if (count($visita) == 0) {
                $visita = new Visitas;
                $visita->fecha = $req->fecha;
                $visita->id_escuela = $req->id_escuela;
                $visita->save();
                //
                $aux = Visitas::all();
                $visita = $aux->last();
            }else{
                $aux = $visita;
                $visita = Visitas::find($aux[0]->id);
            }

            $vOficial = new VisitaOficial;
            $vOficial->id_visita = $visita->id;
            $vOficial->id_oficial = $req->id_oficial;
            $vOficial->aulas = $req->aulas;
            $vOficial->viaticos = $req->viaticos;
            $vOficial->pendientes = $req->pendientes;
            $vOficial->observaciones = $req->observaciones;
            $vOficial->save();

            if (count($req->voluntarios) != 0) {
                foreach ($req->voluntarios as $key => $value) {
                    $vVoluntario = new VisitaVoluntario;
                    $vVoluntario->id_visitaO = $vOficial->id;
                    $vVoluntario->id_voluntario = $value;
                    $vVoluntario->tiempo = $req->voluntariosTime[$key];
                    $vVoluntario->save();
                }   
            }

            foreach ($req->motivos as $key => $value) {
                $vMotivo = new VisitaMotivo;
                $vMotivo->id_visitaO = $vOficial->id;
                $vMotivo->id_motivo = $value;
                $vMotivo->tiempo = $req->motivosTime[$key];
                $vMotivo->save();
            }

            return response()->json([
                'resp' => $vOficial->id
            ]);
        }
    }

    public function listing(){
        $visitas = DB::select("SELECT visitas.fecha, escuelas.nombre AS escuela, visita_oficial.id, 
                                CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial
                                FROM visitas RIGHT JOIN visita_oficial ON visita_oficial.id_visita = visitas.id
                                INNER JOIN escuelas ON visitas.id_escuela = escuelas.id
                                INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id");
        return response()->json(
            $visitas
        );
    }

    public function listingC($area){
        $visitas = DB::select("SELECT visitas.fecha, escuelas.nombre AS escuela, visita_oficial.id, 
                                CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial
                                FROM visitas RIGHT JOIN visita_oficial ON visita_oficial.id_visita = visitas.id
                                INNER JOIN escuelas ON visitas.id_escuela = escuelas.id
                                INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id
                                INNER JOIN areas ON oficiales.id_area = areas.id
                                WHERE areas.id = '$area'");
        return response()->json(
            $visitas
        );
    }

    public function listingO($oficial){
        $visitas = DB::select("SELECT visitas.fecha, escuelas.nombre AS escuela, visita_oficial.id, 
                                CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial
                                FROM visitas RIGHT JOIN visita_oficial ON visita_oficial.id_visita = visitas.id
                                INNER JOIN escuelas ON visitas.id_escuela = escuelas.id
                                INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id
                                WHERE oficiales.id = '$oficial'");
        return response()->json(
            $visitas
        );
    }

    public function detail($id){
        $visita = DB::select("SELECT visitas.fecha, escuelas.nombre AS escuela, departamentos.nombre AS dep, 
                            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial, 
                            visita_oficial.aulas, visita_oficial.viaticos, visita_oficial.pendientes, visita_oficial.observaciones
                            FROM visitas RIGHT JOIN visita_oficial ON visita_oficial.id_visita = visitas.id
                            INNER JOIN escuelas ON visitas.id_escuela = escuelas.id
                            INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id
                            INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id
                            WHERE visita_oficial.id = '$id'");

        $motivos = DB::select("SELECT motivos.nombre as motivo, visita_motivo.tiempo FROM visita_motivo
                                INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id
                                WHERE visita_motivo.id_visitaO = '$id'");

        $voluntarios = DB::select("SELECT CONCAT(voluntarios.nombres, ' ', voluntarios.apellidos) AS voluntario, visita_voluntario.tiempo 
                                FROM visita_voluntario INNER JOIN voluntarios ON visita_voluntario.id_voluntario = voluntarios.id
                                WHERE visita_voluntario.id_visitaO = '$id'");

        return response()->json([
            'visita'=>$visita, 
            'motivos'=>$motivos, 
            'voluntarios'=>$voluntarios
        ]);
    }

    public function infoVisita($id){
        $visita = DB::select("SELECT visitas.id, visitas.fecha, visitas.id_escuela, escuelas.id_departamento, 
                            visita_oficial.id_oficial, oficiales.id_area, visita_oficial.aulas, 
                            visita_oficial.viaticos, visita_oficial.pendientes, visita_oficial.observaciones
                            FROM visitas RIGHT JOIN visita_oficial ON visita_oficial.id_visita = visitas.id
                            INNER JOIN escuelas ON visitas.id_escuela = escuelas.id
                            INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id
                            INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id
                            INNER JOIN areas ON oficiales.id_area = areas.id
                            WHERE visita_oficial.id = '$id'");

        $motivos = DB::select("SELECT visita_motivo.id, visita_motivo.id_motivo, motivos.nombre as motivo, visita_motivo.tiempo 
                                FROM visita_motivo
                                INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id
                                WHERE visita_motivo.id_visitaO = '$id'");

        $voluntarios = DB::select("SELECT visita_voluntario.id, visita_voluntario.id_voluntario, 
                                CONCAT(voluntarios.nombres, ' ', voluntarios.apellidos) AS voluntario, 
                                visita_voluntario.tiempo FROM visita_voluntario 
                                INNER JOIN voluntarios ON visita_voluntario.id_voluntario = voluntarios.id
                                WHERE visita_voluntario.id_visitaO = '$id'");

        return response()->json([
            'visita'=>$visita, 
            'motivos'=>$motivos, 
            'voluntarios'=>$voluntarios
        ]);
    }

    public function edit($id){
        $visita = VisitaOficial::find($id);
        return view('visita.edit', ['visita'=>$visita]);
    }

    public function update(Request $req, $id){
        $visita = DB::select("SELECT * FROM visitas 
            WHERE visitas.fecha = '$req->fecha' AND visitas.id_escuela = '$req->id_escuela'");

        if (count($visita) == 0) {
            $visita = new Visitas;
            $visita->fecha = $req->fecha;
            $visita->id_escuela = $req->id_escuela;
            $visita->save();
            //
            $aux = Visitas::all();
            $visita = $aux->last();
        }else{
            $aux = $visita;
            $visita = Visitas::find($aux[0]->id);
        }

        $vOficial = VisitaOficial::find($id);
        $vOficial->fill([
            'id_visita' => $visita->id, 
            'id_oficial' => $req->id_oficial, 
            'aulas' => $req->aulas, 
            'viaticos' => $req->viaticos, 
            'pendientes' => $req->pendientes, 
            'observaciones' => $req->observaciones
        ]);
        $vOficial->save();

        if (count($req->voluntariosStatus) != 0) {
            foreach ($req->voluntariosStatus as $key => $value) {
                if ($value == 'm') {
                    $vVoluntario = VisitaVoluntario::find($req->voluntariosReg[$key]);
                    $vVoluntario->fill([
                        'id_visitaO' => $id, 
                        'id_voluntario' => $req->voluntarios[$key], 
                        'tiempo' => $req->voluntariosTime[$key]
                    ]);
                    $vVoluntario->save();
                }elseif ($value == 'n') {
                    $vVoluntario = new VisitaVoluntario;
                    $vVoluntario->id_visitaO = $id;
                    $vVoluntario->id_voluntario = $req->voluntarios[$key];
                    $vVoluntario->tiempo = $req->voluntariosTime[$key];
                    $vVoluntario->save();
                }elseif ($value == 'd') {
                    $vVoluntario = VisitaVoluntario::find($req->voluntariosReg[$key]);
                    $vVoluntario->delete();
                }
            }   
        }

        foreach ($req->motivosStatus as $key => $value) {
            if ($value == 'm') {
                $vMotivo = VisitaMotivo::find($req->motivosReg[$key]);
                $vMotivo->fill([
                    'id_visitaO' => $id, 
                    'id_motivo' => $req->motivos[$key], 
                    'tiempo' => $req->motivosTime[$key]
                ]);
                $vMotivo->save();
            }elseif ($value == 'n') {
                $vMotivo = new VisitaMotivo;
                $vMotivo->id_visitaO = $id;
                $vMotivo->id_motivo = $req->motivos[$key];
                $vMotivo->tiempo = $req->motivosTime[$key];
                $vMotivo->save();
            }elseif ($value == 'd') {
                $vMotivo = VisitaMotivo::find($req->motivosReg[$key]);
                $vMotivo->delete();
            }
        }

        return response()->json([
            'mensaje' => 'Registros actualizados'
        ]);
    }

    public function destroy($id){
        DB::table('visita_voluntario')->where('id_visitaO','=',$id)->delete();
        DB::table('visita_motivo')->where('id_visitaO','=',$id)->delete();

        $visita = VisitaOficial::find($id);
        $visita->delete();

        return response()->json(['mensaje'=>'registros eliminados']);
    }

    public function charts(){
        return view('visita.charts');
    }

    public function report(){
        return view('visita.report');
    }


    /*public function listingU($name){
        $visitas = DB::select("SELECT * FROM
            (SELECT visitas.id, visitas.fecha, 
            escuelas.nombre AS escuela, departamentos.nombre AS dep, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial, visitas.aulas 
            FROM visitas, escuelas, oficiales, departamentos 
            WHERE visitas.id_escuela = escuelas.id
            AND escuelas.id_departamento = departamentos.id
            AND visitas.id_oficial = oficiales.id) AS consulta
            WHERE consulta.oficial = '$name'");
        return response()->json(
            $visitas
        );
    }

    public function listingByEsc($idEsc){
        $visitas = DB::select("SELECT visitas.id, visitas.fecha, 
            escuelas.nombre AS escuela, departamentos.nombre AS dep, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial, visitas.aulas 
            FROM visitas, escuelas, oficiales, departamentos 
            WHERE visitas.id_escuela = escuelas.id
            AND escuelas.id_departamento = departamentos.id
            AND visitas.id_oficial = oficiales.id
            AND escuelas.nombre LIKE '%".$idEsc."%'");
        return response()->json(
            $visitas
        );
    }
    public function listingByOfi($idOfi){
        $visitas = DB::select("SELECT visitas.id, visitas.fecha, 
            escuelas.nombre AS escuela, departamentos.nombre AS dep, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial, visitas.aulas 
            FROM visitas, escuelas, oficiales, departamentos 
            WHERE visitas.id_escuela = escuelas.id
            AND escuelas.id_departamento = departamentos.id
            AND visitas.id_oficial = oficiales.id
            AND visitas.id_oficial = '$idOfi'");
        return response()->json(
            $visitas
        );
    }
    public function listingByDate($date){
        $visitas = DB::select("SELECT visitas.id, visitas.fecha, 
            escuelas.nombre AS escuela, departamentos.nombre AS dep, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial, visitas.aulas 
            FROM visitas, escuelas, oficiales, departamentos 
            WHERE visitas.id_escuela = escuelas.id
            AND escuelas.id_departamento = departamentos.id
            AND visitas.id_oficial = oficiales.id
            AND visitas.fecha = '$date'");
        return response()->json(
            $visitas
        );
    }
    public function listingByArea($idAr){
        $visitas = DB::select("SELECT visitas.id, visitas.fecha, 
            escuelas.nombre AS escuela, departamentos.nombre AS dep, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) as oficial, visitas.aulas 
            FROM visitas, escuelas, oficiales, departamentos, areas 
            WHERE visitas.id_escuela = escuelas.id
            AND escuelas.id_departamento = departamentos.id
            AND visitas.id_oficial = oficiales.id
            AND oficiales.id_area = areas.id
            AND oficiales.id_area = '$idAr'");
        return response()->json(
            $visitas
        );
    }

    public function visitasByDep($ini, $fin){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, departamentos.nombre 
            FROM visitas, escuelas, departamentos 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' AND visitas.fecha <= '$fin' 
            GROUP BY escuelas.id_departamento");

        $visitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, departamentos.nombre 
            FROM visitas, escuelas, departamentos 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' AND visitas.fecha <= '$fin'
            GROUP BY visitas.fecha, visitas.id_escuela");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_departamento==$visitas[$indice]->id_departamento) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_departamento]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByDepDet($ini, $fin, $idDep){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, escuelas.nombre
            FROM visitas, escuelas, departamentos 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND departamentos.id = '$idDep'
            GROUP BY visitas.id_escuela");

        $visitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, escuelas.nombre
            FROM visitas, escuelas, departamentos 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND departamentos.id = '$idDep'
            GROUP BY visitas.id_escuela, visitas.fecha");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_escuela==$visitas[$indice]->id_escuela) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }
    //***************************************************

    public function visitasByArea($ini, $fin){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, oficiales.id_area, areas.nombre
            FROM visitas, oficiales, areas
            WHERE visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = areas.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            GROUP BY oficiales.id_area");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, oficiales.id_area, areas.nombre
            FROM visitas, oficiales, areas
            WHERE visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = areas.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_area==$visitas[$indice]->id_area) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_area]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByAreaDet($ini, $fin, $idArea){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, oficiales.id_area, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales, areas
            WHERE visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = areas.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND areas.id = '$idArea'
            GROUP BY visitas.id_oficial");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, oficiales.id_area, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales, areas
            WHERE visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = areas.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND areas.id = '$idArea'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_oficial==$visitas[$indice]->id_oficial) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }
    //***************************************************

    public function visitasByOfi($ini, $fin){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            GROUP BY visitas.id_oficial");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_oficial==$visitas[$indice]->id_oficial) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_oficial]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByOfiDet($ini, $fin, $idOfi){
        $resp = [];
        $idVisitas = DB::select("SELECT detalle_visita.id, detalle_visita.id_motivo, motivos.nombre, visitas.id, visitas.id_oficial 
            FROM detalle_visita, motivos, visitas, oficiales 
            WHERE detalle_visita.id_motivo=motivos.id 
            AND detalle_visita.id_visita=visitas.id 
            AND visitas.id_oficial=oficiales.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi' 
            GROUP BY detalle_visita.id_motivo");

        $visitas = DB::select("SELECT detalle_visita.id, detalle_visita.id_motivo, motivos.nombre, visitas.id, visitas.id_oficial 
            FROM detalle_visita, motivos, visitas, oficiales 
            WHERE detalle_visita.id_motivo=motivos.id 
            AND detalle_visita.id_visita=visitas.id 
            AND visitas.id_oficial=oficiales.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_motivo==$visitas[$indice]->id_motivo) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }
    //***************************************************

    public function visitasByMot($ini, $fin){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, oficiales.id_area, areas.nombre
            FROM visitas, oficiales, areas
            WHERE visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = areas.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            GROUP BY oficiales.id_area");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, oficiales.id_area, areas.nombre
            FROM visitas, oficiales, areas
            WHERE visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = areas.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_area==$visitas[$indice]->id_area) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_area]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByMotDet($ini, $fin, $idArea){
        $resp = [];
        $idVisitas = DB::select("SELECT motivos.id, motivos.nombre, detalle_visita.id_visita, visitas.id_oficial, oficiales.id_area
            FROM detalle_visita, motivos, visitas, oficiales, areas
            WHERE detalle_visita.id_motivo=motivos.id
            AND detalle_visita.id_visita=visitas.id
            AND visitas.id_oficial=oficiales.id
            AND oficiales.id_area=areas.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND oficiales.id_area = '$idArea'
            GROUP BY motivos.id");

        $visitas = DB::select("SELECT motivos.id, motivos.nombre, detalle_visita.id_visita, visitas.id_oficial, oficiales.id_area
            FROM detalle_visita, motivos, visitas, oficiales, areas
            WHERE detalle_visita.id_motivo=motivos.id
            AND detalle_visita.id_visita=visitas.id
            AND visitas.id_oficial=oficiales.id
            AND oficiales.id_area=areas.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND oficiales.id_area = '$idArea'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id==$visitas[$indice]->id) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }
    //***************************************************

    public function visitasByEsc($ini, $fin){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            GROUP BY visitas.id_oficial");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_oficial==$visitas[$indice]->id_oficial) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_oficial]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByEscDet($ini, $fin, $idOfi){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id_oficial, escuelas.id, escuelas.nombre 
            FROM visitas, oficiales, escuelas
            WHERE visitas.id_oficial=oficiales.id 
            AND visitas.id_escuela=escuelas.id  
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'
            GROUP BY visitas.id_escuela");

        $visitas = DB::select("SELECT visitas.id_oficial, escuelas.id, escuelas.nombre 
            FROM visitas, oficiales, escuelas
            WHERE visitas.id_oficial=oficiales.id 
            AND visitas.id_escuela=escuelas.id  
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id==$visitas[$indice]->id) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }


    //*************USUARIOS********************************
    public function visitasByDepU($ini, $fin, $area){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, departamentos.nombre 
            FROM visitas, escuelas, departamentos, oficiales 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' AND visitas.fecha <= '$fin'
            AND visitas.id_oficial = oficiales.id
            AND oficiales.id_area = '$area'
            GROUP BY escuelas.id_departamento");

        $visitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, departamentos.nombre 
            FROM visitas, escuelas, departamentos, oficiales 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' AND visitas.fecha <= '$fin'
            AND visitas.id_oficial = oficiales.id
            AND oficiales.id_area = '$area'
            GROUP BY visitas.fecha, visitas.id_escuela");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_departamento==$visitas[$indice]->id_departamento) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_departamento]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByDepDetU($ini, $fin, $idDep, $area){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, escuelas.nombre
            FROM visitas, escuelas, departamentos, oficiales 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND departamentos.id = '$idDep'
            AND visitas.id_oficial = oficiales.id
            AND oficiales.id_area = '$area'
            GROUP BY visitas.id_escuela");

        $visitas = DB::select("SELECT visitas.id, visitas.id_escuela, escuelas.id_departamento, escuelas.nombre
            FROM visitas, escuelas, departamentos, oficiales 
            WHERE visitas.id_escuela = escuelas.id 
            AND escuelas.id_departamento = departamentos.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND departamentos.id = '$idDep'
            AND visitas.id_oficial = oficiales.id 
            AND oficiales.id_area = '$area'
            GROUP BY visitas.id_escuela, visitas.fecha");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_escuela==$visitas[$indice]->id_escuela) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByOfiU($ini, $fin, $area){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND oficiales.id_area = '$area'
            GROUP BY visitas.id_oficial");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND oficiales.id_area = '$area'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_oficial==$visitas[$indice]->id_oficial) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_oficial]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByOfiDetU($ini, $fin, $idOfi, $area){
        $resp = [];
        $idVisitas = DB::select("SELECT detalle_visita.id, detalle_visita.id_motivo, motivos.nombre, visitas.id, visitas.id_oficial 
            FROM detalle_visita, motivos, visitas, oficiales 
            WHERE detalle_visita.id_motivo=motivos.id 
            AND detalle_visita.id_visita=visitas.id 
            AND visitas.id_oficial=oficiales.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'
            AND oficiales.id_area = '$area' 
            GROUP BY detalle_visita.id_motivo");

        $visitas = DB::select("SELECT detalle_visita.id, detalle_visita.id_motivo, motivos.nombre, visitas.id, visitas.id_oficial 
            FROM detalle_visita, motivos, visitas, oficiales 
            WHERE detalle_visita.id_motivo=motivos.id 
            AND detalle_visita.id_visita=visitas.id 
            AND visitas.id_oficial=oficiales.id 
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'
            AND oficiales.id_area = '$area'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_motivo==$visitas[$indice]->id_motivo) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByEscU($ini, $fin, $area){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND oficiales.id_area = '$area'
            GROUP BY visitas.id_oficial");

        $visitas = DB::select("SELECT visitas.id, visitas.id_oficial, 
            CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre
            FROM visitas, oficiales
            WHERE visitas.id_oficial=oficiales.id
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin'
            AND oficiales.id_area = '$area'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id_oficial==$visitas[$indice]->id_oficial) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant, $idVisitas[$index]->id_oficial]);
        }

        return response()->json(
            $resp   
        );
    }
    public function visitasByEscDetU($ini, $fin, $idOfi, $area){
        $resp = [];
        $idVisitas = DB::select("SELECT visitas.id_oficial, escuelas.id, escuelas.nombre 
            FROM visitas, oficiales, escuelas
            WHERE visitas.id_oficial=oficiales.id 
            AND visitas.id_escuela=escuelas.id  
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'
            AND oficiales.id_area = '$area'
            GROUP BY visitas.id_escuela");

        $visitas = DB::select("SELECT visitas.id_oficial, escuelas.id, escuelas.nombre 
            FROM visitas, oficiales, escuelas
            WHERE visitas.id_oficial=oficiales.id 
            AND visitas.id_escuela=escuelas.id  
            AND visitas.fecha >= '$ini' 
            AND visitas.fecha <= '$fin' 
            AND visitas.id_oficial = '$idOfi'
            AND oficiales.id_area = '$area'");

        for($index=0; $index < count($idVisitas); $index++) { 
            $cant=0;
            for($indice=0; $indice < count($visitas); $indice++) { 
                if ($idVisitas[$index]->id==$visitas[$indice]->id) {
                    $cant++;
                }
            }
            array_push($resp, [$idVisitas[$index]->nombre, $cant]);
        }

        return response()->json(
            $resp   
        );
    }

    /********************************************

    public function cantByArea($idArea){
        $visita = DB::select("SELECT visitas.id, visitas.fecha FROM visitas, oficiales 
            WHERE visitas.id_oficial = oficiales.id AND oficiales.id_area = '$idArea' ");

        return response()->json($visita);
    }
    public function cant(){
        $visita = DB::select("SELECT visitas.id, visitas.fecha FROM visitas ");

        return response()->json($visita);
    }
    public function cantDetByArea($idArea){
        $visita = DB::select("SELECT visitas.id, visitas.fecha, visitas.id_oficial, detalle_visita.id_motivo, oficiales.id_area 
            FROM visitas, oficiales, detalle_visita 
            WHERE visitas.id=detalle_visita.id_visita 
            AND visitas.id_oficial=oficiales.id AND oficiales.id_area='$idArea'");

        return response()->json($visita);
    }
    public function cantOfiByArea($idArea){
        $visita = DB::select("SELECT visitas.id, visitas.fecha, visitas.id_oficial, oficiales.id_area 
            FROM visitas, oficiales WHERE visitas.id_oficial=oficiales.id 
            AND oficiales.id_area='$idArea'");

        return response()->json($visita);
    }
    public function cantEscByArea($idArea){
        $visita = DB::select("SELECT visitas.id, visitas.fecha, visitas.id_escuela, escuelas.nombre, oficiales.id_area 
            FROM visitas, escuelas, oficiales WHERE visitas.id_escuela = escuelas.id 
            AND visitas.id_oficial = oficiales.id AND oficiales.id_area = '$idArea' 
            GROUP BY visitas.fecha, visitas.id_escuela");

        return response()->json($visita);
    }*/


}
