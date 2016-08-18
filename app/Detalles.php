<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Detalles extends Model
{
    public $timestamps = false;

    protected $table = 'detalles';

    protected $fillable = ['nombre', 'id_motivo'];

}
