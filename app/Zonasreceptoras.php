<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Zonasreceptoras extends Model
{
    public $timestamps = false;

    protected $table = 'zonas_receptoras';

    protected $fillable = ['nombre'];
}
