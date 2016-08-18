<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\TallerRequest;
use visitas\Talleres;
use DB;

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
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $talleres = DB::select('SELECT * FROM talleres');
        return response()->json(
            $talleres
        );
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
