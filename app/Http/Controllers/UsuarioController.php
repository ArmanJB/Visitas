<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\UserCreateRequest;
use visitas\Http\Requests\UserUpdateRequest;
use Session;
use Redirect;
use Auth;
use visitas\User;
use DB;
use Carbon\Carbon;

class UsuarioController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
		$this->middleware('admin', ['only' => ['index', 'create', 'store', 'destroy', 'edit']]);
	}

	public function index(){
		return view('usuario.index');
	}

	public function listing(){
		$users = DB::select("SELECT users.id, users.name, users.email, user_types.name AS 'type', 
			CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS 'oficial' FROM users
			LEFT JOIN user_types ON users.id_type = user_types.id
			LEFT JOIN oficiales ON users.id_oficial = oficiales.id");
		return response()->json(
            $users
        );
	}

	public function usersBySearch($search){
		$users = DB::select("SELECT users.id, users.name, users.email, user_types.name AS 'type', 
			CONCAT(oficiales.nombres, ' ', oficiales.apellidos) AS 'oficial' FROM users
			LEFT JOIN user_types ON users.id_type = user_types.id
			LEFT JOIN oficiales ON users.id_oficial = oficiales.id
            WHERE users.name LIKE '%".$search."%'");
		return response()->json(
            $users
        );
	}

	public function detalle($id){
		$user = DB::select("SELECT user_types.id, user_types.name AS 'tipo', 
			oficiales.id AS 'oficial', areas.id AS 'id_area', areas.nombre AS 'area' 
			FROM users LEFT JOIN user_types ON users.id_type=user_types.id 
			LEFT JOIN oficiales ON users.id_oficial=oficiales.id 
			LEFT JOIN areas ON oficiales.id_area=areas.id 
			WHERE users.id = $id");

		if ($user[0]->oficial != null) {
			$visitasMes = DB::select("SELECT visita_oficial.id, visita_oficial.id_oficial 
				FROM visita_oficial
				LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id
				WHERE visita_oficial.id_oficial = ".$user[0]->oficial." AND visitas.fecha >= '".
				Carbon::now()->format('Y-m')."-01' AND visitas.fecha <= '".
				Carbon::now()->format('Y-m')."-31'");

			$escuelasMes = DB::select("SELECT visitas.id_escuela, visita_oficial.id_oficial 
				FROM visita_oficial
				LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id
				WHERE visita_oficial.id_oficial = ".$user[0]->oficial." AND visitas.fecha >= '".
				Carbon::now()->format('Y-m')."-01' AND visitas.fecha <= '".
				Carbon::now()->format('Y-m')."-31' GROUP BY visitas.id_escuela");

			$talleresMes = DB::select("SELECT talleres.id, taller_oficial.id_oficial 
				FROM taller_oficial
				LEFT JOIN talleres ON taller_oficial.id_taller = talleres.id
				WHERE taller_oficial.id_oficial = ".$user[0]->oficial." AND talleres.fecha >= '".
				Carbon::now()->format('Y-m')."-01' AND talleres.fecha <= '".
				Carbon::now()->format('Y-m')."-31'");

			$cumplimiento = 0;
			$cumplimientoMes = DB::select("SELECT metas.meta, periodos.mes, periodos.anio
				FROM metas
				LEFT JOIN periodos ON metas.id_periodo = periodos.id
				WHERE metas.id_oficial = ".$user[0]->oficial." AND periodos.mes = '".
				intval(Carbon::now()->format('m'))."' AND periodos.anio = '".Carbon::now()->format('Y')."'");
			if (count($cumplimientoMes) != 0) {
				$cumplimiento = intval((100*count($visitasMes))/intval($cumplimientoMes[0]->meta));	
			}	
		}else{
			$visitasMes = DB::select("SELECT visitas.id, visitas.fecha 
				FROM visitas
				WHERE visitas.fecha >= '".Carbon::now()->format('Y-m').
				"-01' AND visitas.fecha <= '".Carbon::now()->format('Y-m')."-31'");

			$escuelasMes = DB::select("SELECT visitas.id_escuela, visita_oficial.id_oficial 
				FROM visita_oficial
				LEFT JOIN visitas ON visita_oficial.id_visita = visitas.id
				WHERE visitas.fecha >= '".Carbon::now()->format('Y-m').
				"-01' AND visitas.fecha <= '".Carbon::now()->format('Y-m').
				"-31' GROUP BY visitas.id_escuela");

			$talleresMes = DB::select("SELECT talleres.id, talleres.fecha 
				FROM talleres
				WHERE talleres.fecha >= '".Carbon::now()->format('Y-m').
				"-01' AND talleres.fecha <= '".Carbon::now()->format('Y-m')."-31'");

			$cumplimiento = 0;
			$cumplimientoMes = DB::select("SELECT metas.meta, periodos.mes, periodos.anio
				FROM metas
				LEFT JOIN periodos ON metas.id_periodo = periodos.id
				WHERE periodos.mes = '".intval(Carbon::now()->format('m')).
				"' AND periodos.anio = '".Carbon::now()->format('Y')."'");
			foreach ($cumplimientoMes as $key => $value) {
				$cumplimiento += intval($value->meta);
			}

			if (count($cumplimientoMes) != 0) {
				$cumplimiento = intval((100*count($visitasMes))/intval($cumplimiento));	
			}
		}

		return response()->json(['user'=>$user, 'visitasMes'=>count($visitasMes), 'escuelasMes'=>count($escuelasMes), 'talleresMes'=>count($talleresMes), 'cumplimientoMes'=>$cumplimiento]);
	}

	public function create(){
		return view('usuario.create');
	}

	public function store(UserCreateRequest $req){
		if($req->ajax() ){
    		User::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
	}

	public function edit($id){
		$user = User::find($id);

        return response()->json(
            $user->toArray()
        );
	}

	public function update(UserUpdateRequest $req, $id){
		if($req->id_type == 1){
			$req->merge(['id_oficial'=>null]);
		}

		$user = User::find($id);
		$user->fill($req->all());
		$user->save();
		return response()->json(['mensaje' => 'actualizado']);
	}

	public function destroy($id){
		$user = User::find($id);
        $user->delete();

        return response()->json(['mensaje'=>'eliminado']);
	}

	public function correct($id){
		$user = User::find($id);
		return $user;
	}

	public function types(){
		$types = DB::select('SELECT * FROM user_types');
		return response()->json(
            $types
        );
	}
}
