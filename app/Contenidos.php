<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Contenidos extends Model
{
    public $timestamps = false;

    protected $table = 'contenidos';

    protected $fillable = ['nombre'];
}
