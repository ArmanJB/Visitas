<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Audiencias extends Model
{
    public $timestamps = false;

    protected $table = 'audiencia';

    protected $fillable = ['nombre'];
}
