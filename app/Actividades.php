<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    public $timestamps = false;

    protected $table = 'actividades';

    protected $fillable = ['nombre'];
}
