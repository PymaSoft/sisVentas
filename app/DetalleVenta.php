<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='detalle_venta';
    protected $primaryKey='det_v_id';
    public $timestamps=false;
    protected $fillable =[
    	'ven_id',
    	'art_id',
    	'det_v_cantidad',
        'det_v_precioventa',
    	'det_v_descuento'
    ];
    
    protected $guarded=[

    ];
}
