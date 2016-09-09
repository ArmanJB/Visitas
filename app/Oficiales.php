<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Oficiales extends Model
{
    public $timestamps = false;

    protected $table = 'oficiales';

    protected $fillable = ['nombres', 'apellidos', 'fecha_nac', 'id_area'];
}
