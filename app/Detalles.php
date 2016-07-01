<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    public $timestamps = false;

    protected $table = 'detalle_visita';

    protected $fillable = ['id_visita', 'id_motivo', 'horas'];

}
