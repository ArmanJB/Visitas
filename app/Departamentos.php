<?php

namespace visitas;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
	public $timestamps = false;

    protected $table = 'departamentos';

    protected $fillable = ['nombre'];
}
