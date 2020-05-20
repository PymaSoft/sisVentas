<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';
    protected $primaryKey='ven_id';
    public $timestamps=false;
    protected $fillable =[
    	'cli_id',
    	'ven_tipocomprob',
    	'ven_seriecomprob',
        'ven_numcomprob',
    	'ven_fechahora',
    	'ven_impuesto',
    	'ven_totalventa',
        'ven_estado'
    ];
    protected $guarded=[

    ];
}
