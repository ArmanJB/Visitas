<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class VisitaOficial extends Model
{
    public $timestamps = false;

    protected $table = 'visita_oficial';

    protected $fillable = ['id_visita', 'id_oficial', 'aulas', 'viaticos', 'pendientes', 'observaciones'];
}
