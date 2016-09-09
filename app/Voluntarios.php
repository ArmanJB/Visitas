<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Voluntarios extends Model
{
    public $timestamps = false;

    protected $table = 'voluntarios';

    protected $fillable = ['nombres', 'apellidos'];
}
