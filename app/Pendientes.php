<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Pendientes extends Model
{
    public $timestamps = false;

    protected $table = 'pendientes';

    protected $fillable = ['nombre', 'finalizado', 'id_visita'];
}
