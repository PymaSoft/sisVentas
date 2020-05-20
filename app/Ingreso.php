<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';
    protected $primaryKey='ing_id';
    public $timestamps=false;
    protected $fillable =[
    	'prov_id',
    	'ing_tipocomprob',
    	'ing_seriecomprob',
        'ing_numcomprob',
    	'ing_fecha',
    	'ing_impuesto',
        'ing_estado'
    ];
    protected $guarded=[

    ];
}
