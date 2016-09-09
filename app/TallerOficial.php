<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class TallerOficial extends Model
{
    public $timestamps = false;

    protected $table = 'taller_oficial';

    protected $fillable = ['id_taller', 'id_oficial'];
}
