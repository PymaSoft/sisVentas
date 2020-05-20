<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='detalle_ingreso';
    protected $primaryKey='det_i_id';
    public $timestamps=false;
    protected $fillable =[
    	'ing_id',
    	'art_id',
    	'det_i_cantidad',
        'det_i_preciocompra',
    	'det_i_precioventa'
    ];
    
    protected $guarded=[

    ];
}
