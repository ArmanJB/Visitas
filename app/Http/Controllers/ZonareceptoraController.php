<?php

namespace visitas\Http\Controllers;

use Illuminate\Http\Request;

use visitas\Http\Requests;
use visitas\Http\Requests\ZonareceptoraRequest;
use visitas\Zonasreceptoras;

class ZonareceptoraController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    public function index(){
        return view('zonareceptora.index');
    }

    public function create(){
    	return view('zonareceptora.create');
    }

    public function store(ZonareceptoraRequest $req){
    	if($req->ajax() ){
    		Zonasreceptoras::create($req->all());
    		return response()->json([
    			'mensaje' => "creado"
    		]);
    	}
    }

    public function listing(){
        $zonareceptoras = Zonasreceptoras::all();
        return response()->json(
            $zonareceptoras->toArray()
        );
    }

    public function edit($id){
        $zonareceptora = Zonasreceptoras::find($id);

        return response()->json(
            $zonareceptora->toArray()
        );
    }

    public function update(Request $req, $id){
        $zonareceptora = Zonasreceptoras::find($id);
        $zonareceptora->fill($req->all());
        $zonareceptora->save();

        return response()->json([
            'mensaje' => 'actualizado'
        ]);
    }

    public function destroy($id){
        $zonareceptora = Zonasreceptoras::find($id);
        $zonareceptora->delete();

        return response()->json(['mensaje'=>'borrado']);
    }
}
