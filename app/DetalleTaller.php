<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class DetalleTaller extends Model
{
    public $timestamps = false;

    protected $table = 'detalle_taller';

    protected $fillable = ['id_taller', 'id_escuela', 'id_internacional', 'id_zona'];
}
