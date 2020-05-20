<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table='articulo';
    protected $primaryKey='art_id';
    public $timestamps=false;
    protected $fillable =[
    	'cat_id',
    	'art_codigo',
    	'art_nombre',
    	'art_stock',
    	'art_descripcion',
    	'art_imagen',
    	'art_estado'
    ];
    protected $guarded=[

    ];
}
