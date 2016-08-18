<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
    public $timestamps = false;

    protected $table = 'metas';

    protected $fillable = ['meta', 'id_oficial', 'id_periodo'];
}
