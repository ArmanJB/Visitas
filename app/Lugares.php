<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Lugares extends Model
{
    public $timestamps = false;

    protected $table = 'lugares';

    protected $fillable = ['nombre'];
}
