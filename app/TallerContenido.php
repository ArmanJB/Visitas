<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class TallerContenido extends Model
{
    public $timestamps = false;

    protected $table = 'taller_contenido';

    protected $fillable = ['id_taller', 'id_contenido'];
}
