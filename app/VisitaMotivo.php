<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class VisitaMotivo extends Model
{
    public $timestamps = false;

    protected $table = 'visita_motivo';

    protected $fillable = ['id_visitaO', 'id_motivo', 'tiempo'];
}
