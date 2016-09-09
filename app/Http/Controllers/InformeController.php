<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;
use visitas\Http\Requests;

use DB;
use Carbon\Carbon;

class InformeController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }

    public function resumenArea(){
        $areas = DB::select("SELECT visita_oficial.id_oficial, oficiales.id_area, areas.nombre FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id GROUP BY areas.id");
        $areasCant = DB::select("SELECT visita_oficial.id_oficial, oficiales.id_area, areas.nombre FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id");

        $area = [];
        $oficiales = [];

        foreach ($areas as $key => $value) {
        	$cant = 0;
        	foreach ($areasCant as $key2 => $value2) {
        		if ($value->id_area == $value2->id_area) {
        			$cant++;
        		}
        	}
        	array_push($area, json_encode(['name'=> $value->nombre, 'y'=> $cant, 'drilldown'=> $value->nombre]));
        	
        	$aux = [];
        	$ofcArea = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id WHERE oficiales.id_area = $value->id_area GROUP BY visita_oficial.id_oficial");
        	$ofcAreaCant = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id WHERE oficiales.id_area = $value->id_area");

        	foreach ($ofcArea as $key3 => $value3) {
        		$cant2 = 0;
        		foreach ($ofcAreaCant as $key4 => $value4) {
        			if ($value3->id_oficial == $value4->id_oficial) {
        				$cant2++;
        			}
        		}
        		array_push($aux, json_encode(['name'=> $value3->oficial, 'y'=> $cant2, 'drilldown'=> $value3->oficial]));
        	
        		$aux2 = [];
        		$depOfc = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $value3->id_oficial GROUP BY escuelas.id_departamento");
        		$depOfcCant = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $value3->id_oficial");

        		foreach ($depOfc as $key5 => $value5) {
        			$cant3 = 0;
        			foreach ($depOfcCant as $key6 => $value6) {
        				if ($value5->id_departamento == $value6->id_departamento) {
        					$cant3++;
        				}
        			}
        			array_push($aux2, json_encode(['name'=> $value5->nombre, 'y'=> $cant3, 'drilldown'=> $value5->nombre]));
        		
        			$aux3 = [];
        			$escDep = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND escuelas.id_departamento = $value5->id_departamento GROUP BY visitas.id_escuela");
        			$escDepCant = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND escuelas.id_departamento = $value5->id_departamento");

        			foreach ($escDep as $key7 => $value7) {
        				$cant4 = 0;
        				foreach ($escDepCant as $key8 => $value8) {
        					if ($value7->id_escuela == $value8->id_escuela) {
        						$cant4++;
        					}
        				}
        				array_push($aux3, json_encode(['name'=> $value7->nombre, 'y'=> $cant4, 'drilldown'=> $value7->nombre]));
        			}
        			array_push($oficiales, json_encode(['id'=> $value5->nombre, 'name'=> $value5->nombre, 'data'=> $aux3]));

        		}
        		array_push($oficiales, json_encode(['id'=> $value3->oficial, 'name'=> $value3->oficial, 'data'=> $aux2]));

        	}
        	array_push($oficiales, json_encode(['id'=> $value->nombre, 'name'=> $value->nombre, 'data'=> $aux]));

        }

        return response()->json(['principal' => $area, 'secundarios' => $oficiales]);
    }
    
}