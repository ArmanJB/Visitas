<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\InternacionalRequest;
use visitas\Internacionales;

class InternacionalController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('internacional.index');
    }

    public function create(){
    	return view('internacional.create');
    }

    public function store(InternacionalRequest $req){
    	if($req->ajax() ){
    		Internacionales::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $internacionales = Internacionales::all();
        return response()->json(
            $internacionales->toArray()
        );
    }

    public function edit($id){
        $internacional = Internacionales::find($id);

        return response()->json(
            $internacional->toArray()
        );
    }

    public function update(Request $req, $id){
        $internacional = Internacionales::find($id);
        $internacional->fill($req->all());
        $internacional->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $internacional = Internacionales::find($id);
        $internacional->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
