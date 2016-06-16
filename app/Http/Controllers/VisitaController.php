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
            AND visitas.fecha >= '$ini' AND visitas.fecha <= '$fin'");

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
            AND departamentos.id = '$idDep'");

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
}
