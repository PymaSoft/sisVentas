<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';
    protected $primaryKey='cat_id';
    public $timestamps=false;
    protected $fillable =[
    	'cat_nombre',
    	'cat_descripcion',
    	'cat_condicion'
    ];
    protected $guarded=[

    ];
}