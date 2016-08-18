<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Internacionales extends Model
{
    public $timestamps = false;

    protected $table = 'internacionales';

    protected $fillable = ['nombre'];
}
