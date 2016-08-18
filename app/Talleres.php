<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Talleres extends Model
{
    public $timestamps = false;

    protected $table = 'talleres';

    protected $fillable = ['fecha', 'duracion', 'cant_mujeres', 'cant_hombres', 'observaciones', 'id_lugar', 'id_actividad'];
}
