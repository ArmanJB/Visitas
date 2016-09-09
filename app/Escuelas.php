<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Escuelas extends Model
{
    public $timestamps = false;

    protected $table = 'escuelas';

    protected $fillable = ['nombre', 'id_departamento'];

    public static function escuelasByDep($id){
    	return Escuelas::where('id_departamento', '=', $id)->get();
    }

}
