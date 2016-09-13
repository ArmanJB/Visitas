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

    public function reportTaller(){

    }
}
