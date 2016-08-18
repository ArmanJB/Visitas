<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Periodos extends Model
{
    public $timestamps = false;

    protected $table = 'periodos';

    protected $fillable = ['mes', 'anio'];
}
