<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\AreaRequest;
use visitas\Areas;

class AreaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('area.index');
    }

    public function create(){
    	return view('area.create');
    }

    public function store(AreaRequest $req){
    	if($req->ajax() ){
    		Areas::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $areas = Areas::all();
        return response()->json(
            $areas->toArray()
        );
    }

    public function edit($id){
        $area = Areas::find($id);

        return response()->json(
            $area->toArray()
        );
    }

    public function update(Request $req, $id){
        $area = Areas::find($id);
        $area->fill($req->all());
        $area->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $area = Areas::find($id);
        $area->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
