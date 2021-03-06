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
    /********RESUMEN*****************/

    public function resumenArea($desde, $hasta){
        $areas = DB::select("SELECT visita_oficial.id_oficial, oficiales.id_area, areas.nombre FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY areas.id");
        $areasCant = DB::select("SELECT visita_oficial.id_oficial, oficiales.id_area, areas.nombre FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

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
        	$ofcArea = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE oficiales.id_area = $value->id_area AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_oficial.id_oficial");
        	$ofcAreaCant = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS oficial, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE oficiales.id_area = $value->id_area AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

        	foreach ($ofcArea as $key3 => $value3) {
        		$cant2 = 0;
        		foreach ($ofcAreaCant as $key4 => $value4) {
        			if ($value3->id_oficial == $value4->id_oficial) {
        				$cant2++;
        			}
        		}
        		array_push($aux, json_encode(['name'=> $value3->oficial, 'y'=> $cant2, 'drilldown'=> $value->nombre.$value3->oficial]));
        	
        		$aux2 = [];
        		$depOfc = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY escuelas.id_departamento");
        		$depOfcCant = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

        		foreach ($depOfc as $key5 => $value5) {
        			$cant3 = 0;
        			foreach ($depOfcCant as $key6 => $value6) {
        				if ($value5->id_departamento == $value6->id_departamento) {
        					$cant3++;
        				}
        			}
        			array_push($aux2, json_encode(['name'=> $value5->nombre, 'y'=> $cant3, 'drilldown'=> $value->nombre.$value3->oficial.$value5->nombre]));
        		
        			$aux3 = [];
        			$escDep = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND escuelas.id_departamento = $value5->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visitas.id_escuela");
        			$escDepCant = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND escuelas.id_departamento = $value5->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

        			foreach ($escDep as $key7 => $value7) {
        				$cant4 = 0;
        				foreach ($escDepCant as $key8 => $value8) {
        					if ($value7->id_escuela == $value8->id_escuela) {
        						$cant4++;
        					}
        				}
        				array_push($aux3, json_encode(['name'=> $value7->nombre, 'y'=> $cant4, 'drilldown'=> $value->nombre.$value3->oficial.$value5->nombre.$value7->nombre]));
        			
                        $aux4 = [];
                        $motEsc = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, visita_oficial.id_oficial, escuelas.id_departamento, visitas.id_escuela FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND escuelas.id_departamento = $value5->id_departamento AND visitas.id_escuela = $value7->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_motivo.id_motivo");
                        $motEscCant = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, visita_oficial.id_oficial, escuelas.id_departamento, visitas.id_escuela FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value3->id_oficial AND escuelas.id_departamento = $value5->id_departamento AND visitas.id_escuela = $value7->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                        foreach ($motEsc as $key9 => $value9) {
                            $cant5 = 0;
                            foreach ($motEscCant as $key10 => $value10) {
                                if ($value9->id_motivo == $value10->id_motivo) {
                                    $cant5++;
                                }
                            }
                            array_push($aux4, json_encode(['name'=> $value9->nombre, 'y'=> $cant5, 'drilldown'=> $value9->nombre]));
                        }
                        array_push($oficiales, json_encode(['id'=> $value->nombre.$value3->oficial.$value5->nombre.$value7->nombre, 'name'=> $value7->nombre, 'data'=> $aux4]));

                    }
        			array_push($oficiales, json_encode(['id'=> $value->nombre.$value3->oficial.$value5->nombre, 'name'=> $value5->nombre, 'data'=> $aux3]));

        		}
        		array_push($oficiales, json_encode(['id'=> $value->nombre.$value3->oficial, 'name'=> $value3->oficial, 'data'=> $aux2]));

        	}
        	array_push($oficiales, json_encode(['id'=> $value->nombre, 'name'=> $value->nombre, 'data'=> $aux]));

        }

        return response()->json(['principal' => $area, 'secundarios' => $oficiales]);
    }

    public function resumenDep($desde, $hasta){
        $departamentos = DB::select("SELECT visitas.id_escuela, escuelas.id_departamento, departamentos.nombre FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id  INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY escuelas.id_departamento");
        $departamentosCant = DB::select("SELECT visitas.id_escuela, escuelas.id_departamento, departamentos.nombre FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");
        
        $departamento = [];
        $escuelas = [];

        foreach ($departamentos as $key => $value) {
            $cant = 0;
            foreach ($departamentosCant as $key2 => $value2) {
                if ($value->id_departamento == $value2->id_departamento) {
                    $cant++;
                }
            }
            array_push($departamento, json_encode(['name'=> $value->nombre, 'y'=> $cant, 'drilldown'=> $value->nombre]));

            $aux = [];
            $escDep = DB::select("SELECT visitas.id_escuela, escuelas.nombre, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visitas.id_escuela");
            $escDepCant = DB::select("SELECT visitas.id_escuela, escuelas.nombre, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

            foreach ($escDep as $key3 => $value3) {
                $cant2 = 0;
                foreach ($escDepCant as $key4 => $value4) {
                    if ($value3->id_escuela == $value4->id_escuela) {
                        $cant2++;
                    }
                }
                array_push($aux, json_encode(['name'=> $value3->nombre, 'y'=> $cant2, 'drilldown'=> $value->nombre.$value3->nombre]));

                $aux2 = [];
                $areaEsc = DB::select("SELECT oficiales.id_area, areas.nombre, escuelas.id_departamento, visitas.id_escuela FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY oficiales.id_area");
                $areaEscCant = DB::select("SELECT oficiales.id_area, areas.nombre, escuelas.id_departamento, visitas.id_escuela FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                foreach ($areaEsc as $key5 => $value5) {
                    $cant3 = 0;
                    foreach ($areaEscCant as $key6 => $value6) {
                        if ($value5->id_area == $value6->id_area) {
                            $cant3++;
                        }
                    }
                    array_push($aux2, json_encode(['name'=> $value5->nombre, 'y'=> $cant3, 'drilldown'=> $value->nombre.$value3->nombre.$value5->nombre]));
                
                    $aux3 = [];
                    $ofcArea = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre, escuelas.id_departamento, visitas.id_escuela, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND oficiales.id_area = $value5->id_area AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_oficial.id_oficial");
                    $ofcAreaCant = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre, escuelas.id_departamento, visitas.id_escuela, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND oficiales.id_area = $value5->id_area AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                    foreach ($ofcArea as $key7 => $value7) {
                        $cant4 = 0;
                        foreach ($ofcAreaCant as $key8 => $value8) {
                            if ($value7->id_oficial == $value8->id_oficial) {
                                $cant4++;
                            }
                        }
                        array_push($aux3, json_encode(['name'=> $value7->nombre, 'y'=> $cant4, 'drilldown'=> $value->nombre.$value3->nombre.$value5->nombre.$value7->nombre]));
                    
                        $aux4 = [];
                        $motOfc = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, escuelas.id_departamento, visitas.id_escuela, visita_oficial.id_oficial FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND visita_oficial.id_oficial = $value7->id_oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_motivo.id_motivo");
                        $motOfcCant = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, escuelas.id_departamento, visitas.id_escuela, visita_oficial.id_oficial FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND visita_oficial.id_oficial = $value7->id_oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                        foreach ($motOfc as $key9 => $value9) {
                            $cant5 = 0;
                            foreach ($motOfcCant as $key10 => $value10) {
                                if ($value9->id_motivo == $value10->id_motivo) {
                                    $cant5++;
                                }
                            }
                            array_push($aux4, json_encode(['name'=> $value9->nombre, 'y'=> $cant5, 'drilldown'=> $value9->nombre]));
                        }
                        array_push($escuelas, json_encode(['id'=> $value->nombre.$value3->nombre.$value5->nombre.$value7->nombre, 'name'=> $value7->nombre, 'data'=> $aux4]));

                    }
                    array_push($escuelas, json_encode(['id'=> $value->nombre.$value3->nombre.$value5->nombre, 'name'=> $value5->nombre, 'data'=> $aux3]));

                }
                array_push($escuelas, json_encode(['id'=> $value->nombre.$value3->nombre, 'name'=> $value3->nombre, 'data'=> $aux2]));
            }
            array_push($escuelas, json_encode(['id'=> $value->nombre, 'name'=> $value->nombre, 'data'=> $aux]));
        }

        return response()->json(['principal' => $departamento, 'secundarios' => $escuelas]);
    }

    public function resumenTaller($desde, $hasta){
        $oficiales = DB::select("SELECT talleres.id_actividad, taller_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre FROM taller_oficial INNER JOIN oficiales ON taller_oficial.id_oficial = oficiales.id LEFT JOIN talleres ON taller_oficial.id_taller = talleres.id WHERE talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta' GROUP BY taller_oficial.id_oficial");
        $oficialesCant = DB::select("SELECT talleres.id_actividad, taller_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre FROM taller_oficial INNER JOIN oficiales ON taller_oficial.id_oficial = oficiales.id LEFT JOIN talleres ON taller_oficial.id_taller = talleres.id WHERE talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");

        $oficial = [];
        $actividades = [];

        foreach ($oficiales as $key => $value) {
            $cant = 0;
            foreach ($oficialesCant as $key2 => $value2) {
                if ($value->id_oficial == $value2->id_oficial) {
                    $cant++;
                }
            }
            array_push($oficial, json_encode(['name'=> $value->nombre, 'y'=> $cant, 'drilldown'=> $value->nombre]));
        
            $aux = [];
            $actOfc = DB::select("SELECT talleres.id_actividad, actividades.nombre, taller_oficial.id_oficial FROM taller_oficial LEFT JOIN talleres ON taller_oficial.id_taller = talleres.id INNER JOIN actividades ON talleres.id_actividad = actividades.id WHERE taller_oficial.id_oficial = $value->id_oficial AND talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta' GROUP BY talleres.id_actividad");
            $actOfcCant = DB::select("SELECT talleres.id_actividad, actividades.nombre, taller_oficial.id_oficial FROM taller_oficial LEFT JOIN talleres ON taller_oficial.id_taller = talleres.id INNER JOIN actividades ON talleres.id_actividad = actividades.id WHERE taller_oficial.id_oficial = $value->id_oficial AND talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");

            foreach ($actOfc as $key3 => $value3) {
                $cant2 = 0;
                foreach ($actOfcCant as $key4 => $value4) {
                    if ($value3->id_actividad == $value4->id_actividad) {
                        $cant2++;
                    }
                }
                array_push($aux, json_encode(['name'=> $value3->nombre, 'y'=> $cant2, 'drilldown'=> $value->nombre.$value3->nombre]));
                //
            }
            array_push($actividades, json_encode(['id'=> $value->nombre, 'name'=> $value->nombre, 'data'=> $aux]));
        }

        return response()->json(['principal' => $oficial, 'secundarios' => $actividades]);
    }

    public function resumenCoordinador($desde, $hasta, $area){
        $areas = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE oficiales.id_area = $area AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_oficial.id_oficial");
        $areasCant = DB::select("SELECT visita_oficial.id_oficial, CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS nombre, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE oficiales.id_area = $area AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

        $area = [];
        $oficiales = [];

        foreach ($areas as $key => $value) {
            $cant = 0;
            foreach ($areasCant as $key2 => $value2) {
                if ($value->id_oficial == $value2->id_oficial) {
                    $cant++;
                }
            }
            array_push($area, json_encode(['name'=> $value->nombre, 'y'=> $cant, 'drilldown'=> $value->nombre]));
            
            $aux = [];
            $ofcArea = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $value->id_oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY escuelas.id_departamento");
            $ofcAreaCant = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $value->id_oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

            foreach ($ofcArea as $key3 => $value3) {
                $cant2 = 0;
                foreach ($ofcAreaCant as $key4 => $value4) {
                    if ($value3->id_departamento == $value4->id_departamento) {
                        $cant2++;
                    }
                }
                array_push($aux, json_encode(['name'=> $value3->nombre, 'y'=> $cant2, 'drilldown'=> $value->nombre.$value3->nombre]));
            
                $aux2 = [];
                $depOfc = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value->id_oficial AND escuelas.id_departamento = $value3->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visitas.id_escuela");
                $depOfcCant = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value->id_oficial AND escuelas.id_departamento = $value3->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                foreach ($depOfc as $key5 => $value5) {
                    $cant3 = 0;
                    foreach ($depOfcCant as $key6 => $value6) {
                        if ($value5->id_escuela == $value6->id_escuela) {
                            $cant3++;
                        }
                    }
                    array_push($aux2, json_encode(['name'=> $value5->nombre, 'y'=> $cant3, 'drilldown'=> $value->nombre.$value3->nombre.$value5->nombre]));
                
                    $aux3 = [];
                    $escDep = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, visita_oficial.id_oficial, escuelas.id_departamento, visitas.id_escuela FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value->id_oficial AND escuelas.id_departamento = $value3->id_departamento AND visitas.id_escuela = $value5->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_motivo.id_motivo");
                    $escDepCant = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, visita_oficial.id_oficial, escuelas.id_departamento, visitas.id_escuela FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $value->id_oficial AND escuelas.id_departamento = $value3->id_departamento AND visitas.id_escuela = $value5->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                    foreach ($escDep as $key7 => $value7) {
                        $cant4 = 0;
                        foreach ($escDepCant as $key8 => $value8) {
                            if ($value7->id_motivo == $value8->id_motivo) {
                                $cant4++;
                            }
                        }
                        array_push($aux3, json_encode(['name'=> $value7->nombre, 'y'=> $cant4, 'drilldown'=> $value->nombre.$value3->nombre.$value5->nombre.$value7->nombre]));
                    
                    }
                    array_push($oficiales, json_encode(['id'=> $value->nombre.$value3->nombre.$value5->nombre, 'name'=> $value5->nombre, 'data'=> $aux3]));

                }
                array_push($oficiales, json_encode(['id'=> $value->nombre.$value3->nombre, 'name'=> $value3->nombre, 'data'=> $aux2]));

            }
            array_push($oficiales, json_encode(['id'=> $value->nombre, 'name'=> $value->nombre, 'data'=> $aux]));

        }

        return response()->json(['principal' => $area, 'secundarios' => $oficiales]);
    }

    public function resumenOficial($desde, $hasta, $oficial){
        $areas = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY escuelas.id_departamento");
        $areasCant = DB::select("SELECT escuelas.id_departamento, departamentos.nombre, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id WHERE visita_oficial.id_oficial = $oficial AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

        $area = [];
        $oficiales = [];

        foreach ($areas as $key => $value) {
            $cant = 0;
            foreach ($areasCant as $key2 => $value2) {
                if ($value->id_departamento == $value2->id_departamento) {
                    $cant++;
                }
            }
            array_push($area, json_encode(['name'=> $value->nombre, 'y'=> $cant, 'drilldown'=> $value->nombre]));
            
            $aux = [];
            $ofcArea = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $oficial AND escuelas.id_departamento = $value->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visitas.id_escuela");
            $ofcAreaCant = DB::select("SELECT visitas.id_escuela, escuelas.nombre, visita_oficial.id_oficial, escuelas.id_departamento FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $oficial AND escuelas.id_departamento = $value->id_departamento AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

            foreach ($ofcArea as $key3 => $value3) {
                $cant2 = 0;
                foreach ($ofcAreaCant as $key4 => $value4) {
                    if ($value3->id_escuela == $value4->id_escuela) {
                        $cant2++;
                    }
                }
                array_push($aux, json_encode(['name'=> $value3->nombre, 'y'=> $cant2, 'drilldown'=> $value->nombre.$value3->nombre]));
            
                $aux2 = [];
                $depOfc = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, visita_oficial.id_oficial, escuelas.id_departamento, visitas.id_escuela FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $oficial AND escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta' GROUP BY visita_motivo.id_motivo");
                $depOfcCant = DB::select("SELECT visita_motivo.id_motivo, motivos.nombre, visita_oficial.id_oficial, escuelas.id_departamento, visitas.id_escuela FROM visita_motivo INNER JOIN motivos ON visita_motivo.id_motivo = motivos.id LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id INNER JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id WHERE visita_oficial.id_oficial = $oficial AND escuelas.id_departamento = $value->id_departamento AND visitas.id_escuela = $value3->id_escuela AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");

                foreach ($depOfc as $key5 => $value5) {
                    $cant3 = 0;
                    foreach ($depOfcCant as $key6 => $value6) {
                        if ($value5->id_motivo == $value6->id_motivo) {
                            $cant3++;
                        }
                    }
                    array_push($aux2, json_encode(['name'=> $value5->nombre, 'y'=> $cant3, 'drilldown'=> $value->nombre.$value3->nombre.$value5->nombre]));
                    //
                }
                array_push($oficiales, json_encode(['id'=> $value->nombre.$value3->nombre, 'name'=> $value3->nombre, 'data'=> $aux2]));

            }
            array_push($oficiales, json_encode(['id'=> $value->nombre, 'name'=> $value->nombre, 'data'=> $aux]));

        }

        return response()->json(['principal' => $area, 'secundarios' => $oficiales]);
    }
    
    /**********INFORMES************/

    public function reportTaller($desde, $hasta){
        $talleresAnual = DB::select("SELECT * FROM talleres WHERE talleres.fecha >= '".Carbon::now()->format('Y')."-01-01' AND talleres.fecha <= '".Carbon::now()->format('Y')."-12-31'");
        $talleresRango = DB::select("SELECT * FROM talleres WHERE talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");

        $actividades = [];
        $tallerAct = DB::select("SELECT talleres.duracion, talleres.cant_mujeres, talleres.cant_hombres, talleres.id_actividad FROM talleres WHERE talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");
        $actividad = DB::select("SELECT * FROM actividades");
        $cantT = 0; $persT = 0; $horasT = '00:00:00';
        foreach ($actividad as $key => $value) {
            $cant = 0;
            $pers = 0;
            $horas = '00:00:00';
            foreach ($tallerAct as $key2 => $value2) {
                if ($value->id == $value2->id_actividad) {
                    $cant++;
                    $pers+=($value2->cant_mujeres+$value2->cant_hombres);
                    $horas = strtotime($horas)+strtotime($value2->duracion)-strtotime('00:00:00');
                    $horas = date('H:i', $horas);
                }
            }
            if ($cant > 0) {
                array_push($actividades, ['actividad'=>$value->nombre, 'cant'=>$cant, 'pers'=>$pers, 'duracion'=>$horas]);
            }
            $cantT+=$cant;
            $persT+=$pers;
            $horasT = strtotime($horasT)+strtotime($horas)-strtotime('00:00:00');
            $horasT = date('H:i', $horasT);
        }

        $audiencias = [];
        $tallerAud = DB::select("SELECT taller_audiencia.id_audiencia, talleres.id, talleres.duracion FROM taller_audiencia LEFT JOIN talleres ON taller_audiencia.id_taller = talleres.id WHERE talleres.fecha >= '$desde' AND talleres.id <= '$hasta'");
        $audiencia = DB::select("SELECT * FROM audiencia");
        foreach ($audiencia as $key => $value) {
            $cant = 0;
            $duracion = '00:00:00';
            foreach ($tallerAud as $key2 => $value2) {
                if ($value->id == $value2->id_audiencia) {
                    $cant++;
                    $duracion = strtotime($duracion)+strtotime($value2->duracion)-strtotime('00:00:00');
                    $duracion = date('H:i', $duracion);
                }
            }
            if ($cant > 0) {
                array_push($audiencias, ['audiencia'=>$value->nombre, 'cant'=>$cant, 'duracion'=>$duracion]);
            }
        }

        $contenidos = [];
        $tallerCont = DB::select("SELECT taller_contenido.id_contenido, talleres.id, talleres.duracion FROM taller_contenido LEFT JOIN talleres ON taller_contenido.id_taller = talleres.id WHERE talleres.fecha >= '$desde' AND talleres.id <= '$hasta'");
        $contenido = DB::select("SELECT * FROM contenidos");
        foreach ($contenido as $key => $value) {
            $cant = 0;
            $duracion = '00:00:00';
            foreach ($tallerCont as $key2 => $value2) {
                if ($value->id == $value2->id_contenido) {
                    $cant++;
                    $duracion = strtotime($duracion)+strtotime($value2->duracion)-strtotime('00:00:00');
                    $duracion = date('H:i', $duracion);
                }
            }
            if ($cant > 0) {
                array_push($contenidos, ['contenido'=>$value->nombre, 'cant'=>$cant, 'duracion'=>$duracion]);
            }
        }

        $zonas = [];
        $tallerZona = DB::select("SELECT talleres.id, talleres.duracion, detalle_taller.id_escuela, detalle_taller.id_internacional, detalle_taller.id_zona FROM detalle_taller RIGHT JOIN talleres ON detalle_taller.id_taller = talleres.id WHERE talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");
        $zona = DB::select("SELECT * FROM zonas_receptoras");
        foreach ($zona as $key => $value) {
            $cant = 0;
            $duracion = '00:00:00';
            foreach ($tallerZona as $key2 => $value2) {
                if ($value2->id_zona != null) {
                    if ($value->id == $value2->id_zona) {
                        $cant++;
                        $duracion = strtotime($duracion)+strtotime($value2->duracion)-strtotime('00:00:00');
                        $duracion = date('H:i', $duracion);
                    }
                }
            }
            if ($cant > 0) {
                array_push($zonas, ['zona'=>$value->nombre, 'cant'=>$cant, 'duracion'=>$duracion]);
            }
        }
        $zona = DB::select("SELECT * FROM internacionales");
        foreach ($zona as $key => $value) {
            $cant = 0;
            $duracion = '00:00:00';
            foreach ($tallerZona as $key2 => $value2) {
                if ($value2->id_internacional != null) {
                    if ($value->id == $value2->id_internacional) {
                        $cant++;
                        $duracion = strtotime($duracion)+strtotime($value2->duracion)-strtotime('00:00:00');
                        $duracion = date('H:i', $duracion);
                    }
                }
            }
            if ($cant > 0) {
                array_push($zonas, ['zona'=>$value->nombre.' (Internacional)', 'cant'=>$cant, 'duracion'=>$duracion]);
            }
        }
        $zona = DB::select("SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS departamento FROM escuelas INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id");
        foreach ($zona as $key => $value) {
            $cant = 0;
            $duracion = '00:00:00';
            foreach ($tallerZona as $key2 => $value2) {
                if ($value2->id_escuela != null) {
                    if ($value->id == $value2->id_escuela) {
                        $cant++;
                        $duracion = strtotime($duracion)+strtotime($value2->duracion)-strtotime('00:00:00');
                        $duracion = date('H:i', $duracion);
                    }
                }
            }
            if ($cant > 0) {
                array_push($zonas, ['zona'=>$value->nombre.' (Escuela en '.$value->departamento.')', 'cant'=>$cant, 'duracion'=>$duracion]);
            }
        }

        $oficial = DB::select("SELECT * FROM oficiales WHERE oficiales.id_area = 3");

        $viaticos = [];
        $tallerVia = DB::select("SELECT talleres.id, talleres.viaticos, taller_oficial.id_oficial FROM talleres INNER JOIN taller_oficial ON taller_oficial.id_taller = talleres.id INNER JOIN oficiales ON taller_oficial.id_oficial = oficiales.id WHERE talleres.fecha >= '$desde' AND talleres.id <= '$hasta' GROUP BY talleres.id");
        foreach ($oficial as $key => $value) {
            $cant = 0;
            foreach ($tallerVia as $key2 => $value2) {
                if ($value->id == $value2->id_oficial) {
                    $cant += $value2->viaticos;
                }
            }
            if ($cant > 0) {
                array_push($viaticos, ['oficial'=>$value->nombres.' '.$value->apellidos, 'viatico'=>$cant]);
            }
        }        


        $oficiales = []; $data = [];
        $visitas = []; $talleres = [];
        $tallerOfc = DB::select("SELECT taller_oficial.id_oficial, talleres.fecha FROM taller_oficial LEFT JOIN talleres ON taller_oficial.id_taller = talleres.id WHERE talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");
        $visitaOfc = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE oficiales.id_area = 3 AND visitas.fecha >= '$desde' AND visitas.fecha <= '$hasta'");
        foreach ($oficial as $key => $value) {
            $cant = 0;
            foreach ($visitaOfc as $key2 => $value2) {
                if ($value->id == $value2->id_oficial) {
                    $cant++;
                }
            }
            $cant2 = 0;
            foreach ($tallerOfc as $key3 => $value3) {
                if ($value->id == $value3->id_oficial) {
                    $cant2++;
                }
            }
            if ($cant > 0 || $cant2 > 0) {
                array_push($oficiales, $value->nombres.' '.$value->apellidos);
                array_push($visitas, $cant);
                array_push($talleres, $cant2);
            }
        }
        array_push($data, json_encode(['name'=> 'Visitas', 'data'=> $visitas]));
        array_push($data, json_encode(['name'=> 'Talleres', 'data'=> $talleres]));

        //ESCUELAS
        $escuelasAux = DB::select("SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS departamento FROM escuelas LEFT JOIN departamentos ON escuelas.id_departamento = departamentos.id");

        $atendidas = [];
        $atendidasF = [];
        $atendida = DB::select("SELECT detalle_taller.id_escuela, talleres.fecha FROM detalle_taller LEFT JOIN talleres ON detalle_taller.id_taller = talleres.id WHERE detalle_taller.id_escuela IS NOT NULL AND talleres.fecha >= '$desde' AND talleres.fecha <= '$hasta'");
        foreach ($escuelasAux as $key => $value) {
            $cant = 0;
            foreach ($atendida as $key2 => $value2) {
                if ($value->id == $value2->id_escuela) {
                    $cant++;
                }
            }
            if ($cant > 0) {
                array_push($atendidas, ['escuela'=>$value->nombre, 'departamento'=>$value->departamento, 'talleres'=>$cant]);
            }else{
                array_push($atendidasF, ['escuela'=>$value->nombre, 'departamento'=>$value->departamento]);
            }
        }
        
        return response()->json(['anual'=>count($talleresAnual), 'cant'=>count($talleresRango), 
            'actividades'=>$actividades, 'actividadesT'=>['cant'=>$cantT, 'pers'=>$persT, 'duracion'=>$horasT], 
            'audiencias'=>$audiencias, 'contenidos'=>$contenidos, 'zonas'=>$zonas, 'viaticos'=>$viaticos, 'atendidas'=>$atendidas, 'atendidasF'=>$atendidasF, 
            'comparativo'=>['oficiales'=>$oficiales, 'data'=>$data]]);
    }

    public function reportVisita($periodo){
        $periodoAux = DB::select("SELECT * FROM periodos WHERE periodos.id = '$periodo'");
        //
        $planeado = DB::select("SELECT metas.meta, periodos.mes, periodos.anio FROM metas LEFT JOIN periodos ON metas.id_periodo = periodos.id WHERE periodos.id = '$periodo'");
        $cant = 0;
        foreach ($planeado as $key => $value) {
            $cant += intval($value->meta);
        }
        $ejecutado = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '".$planeado[0]->anio."-".$planeado[0]->mes."-01' AND visitas.fecha <= '".$planeado[0]->anio."-".$planeado[0]->mes."-31'");

        $planeadoAnual = DB::select("SELECT metas.meta, periodos.mes, periodos.anio FROM metas LEFT JOIN periodos ON metas.id_periodo = periodos.id WHERE periodos.anio = '".$planeado[0]->anio."'");
        $cantAnual = 0;
        foreach ($planeadoAnual as $key => $value) {
            $cantAnual += intval($value->meta);
        }
        $ejecutadoAnual = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '".$planeadoAnual[0]->anio."-01-01' AND visitas.fecha <= '".$planeadoAnual[0]->anio."-12-31'");

        // AREAS
        $motivosAux = DB::select("SELECT * FROM motivos");
        $escuelasAux = DB::select("SELECT escuelas.id, escuelas.nombre, departamentos.nombre AS departamento FROM escuelas LEFT JOIN departamentos ON escuelas.id_departamento = departamentos.id");
        $areas = [];
        $motivos = [];
        $oficiales = [];
        $escuelas = [];
        $escuelasP = [];
        $viaticos = [];

        $area = DB::select("SELECT * FROM areas");
        foreach ($area as $key => $value) {
            $planArea = DB::select("SELECT metas.meta, periodos.mes, periodos.anio, oficiales.id_area FROM metas LEFT JOIN periodos ON metas.id_periodo = periodos.id INNER JOIN oficiales ON metas.id_oficial = oficiales.id INNER JOIN areas ON oficiales.id_area = areas.id WHERE periodos.id = '$periodo' AND oficiales.id_area = '$value->id'");
            $cantAux = 0;
            foreach ($planArea as $key2 => $value2) {
                $cantAux += intval($value2->meta);
            }
            $ejecArea = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha, oficiales.id_area FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31' AND oficiales.id_area = '$value->id'");
            $planAreaAnual = DB::select("SELECT metas.meta, periodos.mes, periodos.anio, oficiales.id_area FROM metas LEFT JOIN periodos ON metas.id_periodo = periodos.id INNER JOIN oficiales ON metas.id_oficial = oficiales.id WHERE periodos.anio = '".$periodoAux[0]->anio."' AND oficiales.id_area = '$value->id'");
            $cantAnualAux = 0;
            foreach ($planAreaAnual as $key2 => $value2) {
                $cantAnualAux += intval($value2->meta);
            }
            $ejecAreaAnual = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha, oficiales.id_area FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE visitas.fecha >= '".$periodoAux[0]->anio."-01-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-12-31' AND oficiales.id_area = '$value->id'");
            array_push($areas, ['area'=>$value->nombre, 'id'=>'area'.$value->id, 'planeado'=>$cantAux, 'ejecutado'=>count($ejecArea), 'planeadoAnual'=>$cantAnualAux, 'ejecutadoAnual'=>count($ejecAreaAnual)]);
            
            //motivos
            $motivo = DB::select("SELECT visita_motivo.id_motivo, visita_motivo.tiempo, oficiales.id_area, visitas.fecha FROM visita_motivo LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE oficiales.id_area = '$value->id' AND visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31'");
            $motivosCantDur = [];
            foreach ($motivosAux as $key2 => $value2) {
                $cantMot = 0;
                $duracionMot = '00:00:00';
                foreach ($motivo as $key3 => $value3) {
                    if ($value2->id == $value3->id_motivo) {
                        $cantMot++;
                        $duracionMot = strtotime($duracionMot)+strtotime($value3->tiempo)-strtotime('00:00:00');
                        $duracionMot = date('H:i', $duracionMot);
                    }
                }
                if ($cantMot > 0) {
                    array_push($motivosCantDur, ['motivo'=>$value2->nombre, 'cantidad'=>$cantMot, 'tiempo'=>$duracionMot]);   
                }
            }
            array_push($motivos, ['area'=>$value->nombre, 'id'=>'area'.$value->id, 'motivos'=>$motivosCantDur]);

            //oficiales
            $oficial = DB::select("SELECT metas.meta, metas.id_oficial, oficiales.nombres, oficiales.apellidos, oficiales.id_area FROM metas LEFT JOIN oficiales ON metas.id_oficial = oficiales.id WHERE oficiales.id_area = '$value->id' AND metas.id_periodo = '$periodo'");
            $oficialesMeta = [];
            foreach ($oficial as $key2 => $value2) {
                $oficialMetaAux = DB::select("SELECT visita_oficial.id_visita, visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visita_oficial.id_oficial = '$value2->id_oficial' AND visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31'");
                array_push($oficialesMeta, ['oficial'=>$value2->nombres.' '.$value2->apellidos, 'meta'=>$value2->meta, 'visitas'=>count($oficialMetaAux)]);
            }
            array_push($oficiales, ['area'=>$value->nombre, 'id'=>'area'.$value->id, 'oficiales'=>$oficialesMeta]);

            //viaticos
            $oficial = DB::select("SELECT * FROM oficiales WHERE oficiales.id_area = '$value->id'");
            $oficialViatico = [];
            foreach ($oficial as $key2 => $value2) {
                $viatico = DB::select("SELECT visitas.fecha, visita_oficial.viaticos, oficiales.id_area FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE visita_oficial.id_oficial = '$value2->id' AND visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31'");
                $viaticoAnual = DB::select("SELECT visitas.fecha, visita_oficial.viaticos, oficiales.id_area FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE visita_oficial.id_oficial = '$value2->id' AND visitas.fecha >= '".$periodoAux[0]->anio."-01-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-12-31'");
                $cantViatico = 0;
                $cantViaticoAnual = 0;
                foreach ($viatico as $key3 => $value3) {
                    $cantViatico += $value3->viaticos;
                }
                foreach ($viaticoAnual as $key3 => $value3) {
                    $cantViaticoAnual += $value3->viaticos;
                }
                if ($cantViatico > 0) {
                    array_push($oficialViatico, ['oficial'=>$value2->nombres.' '.$value2->apellidos, 'viaticos'=>$cantViatico, 'anual'=>$cantViaticoAnual]);   
                }
            }
            array_push($viaticos, ['area'=>$value->nombre, 'id'=>'area'.$value->id, 'oficiales'=>$oficialViatico]);
                

            //escuelas
            $escuela = DB::select("SELECT visitas.id_escuela, escuelas.nombre, departamentos.nombre AS departamento, visitas.fecha, oficiales.id_area FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id INNER JOIN escuelas ON visitas.id_escuela = escuelas.id INNER JOIN departamentos ON escuelas.id_departamento = departamentos.id INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE oficiales.id_area = '$value->id' AND visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31' GROUP BY visitas.id_escuela ORDER BY departamentos.nombre");
            $escuelasvisita = [];
            $tiempoTotal = '00:00';
            foreach ($escuela as $key2 => $value2) {
                $escuelaVisitaAux = DB::select("SELECT visita_motivo.tiempo, visita_oficial.id_visita, visitas.id_escuela, oficiales.id_area FROM visita_motivo LEFT JOIN visita_oficial ON visita_motivo.id_visitaO = visita_oficial.id LEFT JOIN oficiales ON visita_oficial.id_oficial = oficiales.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE oficiales.id_area = '$value->id' AND visitas.id_escuela = '$value2->id_escuela' AND visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31'");
                $tiempo = '00:00';
                foreach ($escuelaVisitaAux as $key3 => $value3) {
                    $tiempo = strtotime($tiempo)+strtotime($value3->tiempo)-strtotime('00:00:00');
                    $tiempo = date('H:i', $tiempo);
                }
                array_push($escuelasvisita, ['departamento'=>$value2->departamento, 'escuela'=>$value2->nombre, 'tiempo'=>$tiempo]);
                $tiempoTotal = strtotime($tiempoTotal)+strtotime($tiempo)-strtotime('00:00:00');
                $tiempoTotal = date('H:i', $tiempoTotal);
            }
            array_push($escuelas, ['area'=>$value->nombre, 'id'=>'area'.$value->id, 'total'=>$tiempoTotal, 'escuelas'=>$escuelasvisita]);

            //escuelas pendientes
            $escuelaP = DB::select("SELECT visitas.id_escuela, visitas.fecha, visita_oficial.id_oficial, oficiales.id_area FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id LEFT JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE oficiales.id_area = '$value->id' AND visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31' GROUP BY visitas.id_escuela");
            $escuelasPvisita = [];
            foreach ($escuelasAux as $key2 => $value2) {
                $cantEscuelas = 0;
                foreach ($escuelaP as $key3 => $value3) {
                    if ($value2->id == $value3->id_escuela) {
                        $cantEscuelas++;
                    }
                }
                if ($cantEscuelas == 0) {
                    array_push($escuelasPvisita, ['escuela'=>$value2->nombre, 'departamento'=>$value2->departamento]);   
                }
            }
            array_push($escuelasP, ['area'=>$value->nombre, 'id'=>'area'.$value->id, 'escuelas'=>$escuelasPvisita]);


        }

        //VOLUNTARIOS
        $voluntariosAux = DB::select("SELECT voluntarios.id, CONCAT(voluntarios.nombres, ' ', voluntarios.apellidos) as voluntario FROM voluntarios");
        $voluntarios = [];
        $voluntario = DB::select("SELECT visita_voluntario.id_voluntario, visita_voluntario.tiempo, visitas.fecha FROM visita_voluntario LEFT JOIN visita_oficial ON visita_voluntario.id_visitaO = visita_oficial.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31'");
        $voluntarioAnual = DB::select("SELECT visita_voluntario.id_voluntario, visita_voluntario.tiempo, visitas.fecha FROM visita_voluntario LEFT JOIN visita_oficial ON visita_voluntario.id_visitaO = visita_oficial.id LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '".$periodoAux[0]->anio."-01-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-12-31'");
        $totalVol = '00:00';
        $totalVolAnual = '00:00';
        foreach ($voluntariosAux as $key => $value) {
            $tiempoVol = '00:00';
            $tiempoVolAnual = '00:00';
            foreach ($voluntario as $key2 => $value2) {
                if ($value->id == $value2->id_voluntario) {
                    $tiempoVol = strtotime($tiempoVol)+strtotime($value2->tiempo)-strtotime('00:00:00');
                    $tiempoVol = date('H:i', $tiempoVol);
                }
            }
            foreach ($voluntarioAnual as $key2 => $value2) {
                if ($value->id == $value2->id_voluntario) {
                    $tiempoVolAnual = strtotime($tiempoVolAnual)+strtotime($value2->tiempo)-strtotime('00:00:00');
                    $tiempoVolAnual = date('H:i', $tiempoVolAnual);
                }
            }
            if ($tiempoVol != '00:00') {
                array_push($voluntarios, ['voluntario'=>$value->voluntario, 'tiempo'=>$tiempoVol, 'anual'=>$tiempoVolAnual]);
            }
            $totalVol = strtotime($totalVol)+strtotime($tiempoVol)-strtotime('00:00:00');
            $totalVol = date('H:i', $totalVol);
            $totalVolAnual = strtotime($totalVolAnual)+strtotime($tiempoVolAnual)-strtotime('00:00:00');
            $totalVolAnual = date('H:i', $totalVolAnual);
        }

        //ARTICULADAS
        $articulada = DB::select("SELECT visitas.id, visitas.fecha, visitas.id_escuela FROM visitas WHERE visitas.fecha >= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-01' AND visitas.fecha <= '".$periodoAux[0]->anio."-".$periodoAux[0]->mes."-31'");
        $articuladas = [];
        foreach ($escuelasAux as $key => $value) {
            $cantArt = 0;
            foreach ($articulada as $key2 => $value2) {
                if ($value->id == $value2->id_escuela) {
                    $artAux = DB::select("SELECT visita_oficial.id_oficial, oficiales.id_area FROM visita_oficial INNER JOIN oficiales ON visita_oficial.id_oficial = oficiales.id WHERE visita_oficial.id_visita = '$value2->id'");
                    if (count($artAux) > 1) {
                        $cantArt++;
                    }   
                }
            }
            if ($cantArt > 0) {
                array_push($articuladas, ['escuela'=>$value->nombre, 'departamento'=>$value->departamento, 'cant'=>$cantArt]);   
            }
        }//
        $data = [];
        $visitasData = [];
        $visitasDataAnt = [];
        for ($i = 1; $i <12; $i++) { 
            $visitasGral = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '2016-$i-01' AND visitas.fecha <= '2016-$i-31'");
            $visitasGralAnt = DB::select("SELECT visita_oficial.id_oficial, visitas.fecha FROM visita_oficial LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id WHERE visitas.fecha >= '".((Carbon::now()->format('Y'))-1)."-$i-01' AND visitas.fecha <= '".((Carbon::now()->format('Y'))-1)."-$i-31'");
            array_push($visitasData, count($visitasGral));
            array_push($visitasDataAnt, count($visitasGralAnt));
        }
        array_push($data, json_encode(['name'=> (Carbon::now()->format('Y'))-1, 'data'=> $visitasDataAnt]));
        array_push($data, json_encode(['name'=> 'Visitas', 'data'=> $visitasData]));

        return response()->json([
            'consolidado'=>['mes'=>['planeado'=>$cant, 'ejecutado'=>count($ejecutado)], 'anual'=>['planeado'=>$cantAnual, 'ejecutado'=>count($ejecutadoAnual)]],
            'areas'=>$areas,
            'motivos'=>$motivos,
            'oficiales'=>$oficiales,
            'escuelas'=>$escuelas,
            'escuelasP'=>$escuelasP,
            'viaticos'=>$viaticos,
            'articuladas'=>$articuladas,
            'voluntarios'=>$voluntarios,
            'totalVol'=>$totalVol,
            'totalVolAnual'=>$totalVolAnual,
            'data'=>$data
        ]);
    }

}
