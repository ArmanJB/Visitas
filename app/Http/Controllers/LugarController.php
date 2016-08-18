<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\LugarRequest;
use visitas\Lugares;

class LugarController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('lugar.index');
    }

    public function create(){
    	return view('lugar.create');
    }

    public function store(LugarRequest $req){
    	if($req->ajax() ){
    		Lugares::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $lugares = Lugares::all();
        return response()->json(
            $lugares->toArray()
        );
    }

    public function edit($id){
        $lugar = Lugares::find($id);

        return response()->json(
            $lugar->toArray()
        );
    }

    public function update(Request $req, $id){
        $lugar = Lugares::find($id);
        $lugar->fill($req->all());
        $lugar->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $lugar = Lugares::find($id);
        $lugar->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
