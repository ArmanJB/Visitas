<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\PeriodoRequest;
use visitas\Periodos;

class PeriodoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        //return view('periodo.index');
    }

    public function create(){
    	//return view('periodo.create');
    }

    public function store(PeriodoRequest $req){
    	if($req->ajax() ){
    		Periodos::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $periodos = Periodos::all();
        return response()->json(
            $periodos->toArray()
        );
    }

    public function edit($id){
        $periodo = Periodos::find($id);

        return response()->json(
            $periodo->toArray()
        );
    }

    public function update(Request $req, $id){
        $periodo = Periodos::find($id);
        $periodo->fill($req->all());
        $periodo->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $periodo = Periodos::find($id);
        $periodo->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
