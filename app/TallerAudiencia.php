<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class TallerAudiencia extends Model
{
    public $timestamps = false;

    protected $table = 'taller_audiencia';

    protected $fillable = ['id_taller', 'id_audiencia'];
}
