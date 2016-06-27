<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;

use visitas\Areas;
use visitas\Departamentos;
use visitas\Oficiales;
use visitas\Motivos;
use visitas\Escuelas;

use visitas\Visitas;
use visitas\Detalles;
use visitas\Pendientes;

use visitas\User;
use DB;

class MobileController extends Controller
{
    public function data($user, $token){
		$users = DB::select("SELECT users.id FROM users WHERE users.email='$user' AND users.id='$token'");
		if (Count($users) > 0) {
			$area = Areas::all();
	    	$departamento = Departamentos::all();
	    	$oficial = Oficiales::all();
	    	$motivo = Motivos::all();
	    	$escuela = Escuelas::all();

	        if ($area and $departamento and $oficial and $motivo and $escuela) {
	            $datos["estado"] = 1;
	            $datos["areas"] = $area->toArray();
	            $datos["departamentos"] = $departamento->toArray();
	            $datos["oficiales"] = $oficial->toArray();
	            $datos["motivos"] = $motivo->toArray();
	            $datos["escuelas"] = $escuela->toArray();

	            print json_encode($datos);
	        } else {
	            print json_encode(array(
	                "estado" => 2,
	                "mensaje" => "Ha ocurrido un error"
	            ));
	        }
		}else{
			print json_encode(array(
	            "estado" => 2,
	            "mensaje" => "Token no existe"
	        ));
		}

    }

    public function insert($fecha, $id_escuela, $id_oficial, $pendiente, $motivos){
    	print json_encode([
    		"fecha"=>$fecha,
    		"escuela"=>$id_escuela,
    		"oficial"=>$id_oficial,
    		"pendiente"=>$pendiente,
    		"motivo"=>unserialize($motivos)

    	]);
    }
}
