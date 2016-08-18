<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    public $timestamps = false;

    protected $table = 'areas';

    protected $fillable = ['nombre'];
}
