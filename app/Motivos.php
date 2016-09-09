<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Motivos extends Model
{
    public $timestamps = false;

    protected $table = 'motivos';

    protected $fillable = ['nombre', 'id_area'];
}
