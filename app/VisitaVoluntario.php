<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class VisitaVoluntario extends Model
{
    public $timestamps = false;

    protected $table = 'visita_voluntario';

    protected $fillable = ['id_visitaO', 'id_voluntario', 'tiempo'];
}
