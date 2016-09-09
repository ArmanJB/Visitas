<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\ContenidoRequest;
use visitas\Contenidos;

class ContenidoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('contenido.index');
    }

    public function create(){
    	return view('contenido.create');
    }

    public function store(ContenidoRequest $req){
    	if($req->ajax() ){
    		Contenidos::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $contenidos = Contenidos::all();
        return response()->json(
            $contenidos->toArray()
        );
    }

    public function edit($id){
        $contenido = Contenidos::find($id);

        return response()->json(
            $contenido->toArray()
        );
    }

    public function update(Request $req, $id){
        $contenido = Contenidos::find($id);
        $contenido->fill($req->all());
        $contenido->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $contenido = Contenidos::find($id);
        $contenido->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
