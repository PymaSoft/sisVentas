<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';
    protected $primaryKey='per_id';
    public $timestamps=false;
    protected $fillable =[
    	'per_tipo',
    	'per_nombre',
    	'per_tipodoc',
    	'per_numdoc',
    	'per_direccion',
    	'per_telefono',
    	'per_celular',
    	'per_email'
    ];
    protected $guarded=[

    ];
}
