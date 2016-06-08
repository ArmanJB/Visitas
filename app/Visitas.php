<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Visitas extends Model
{
    public $timestamps = false;

    protected $table = 'visitas';

    protected $fillable = ['fecha', 'id_escuela', 'id_oficial'];
}
