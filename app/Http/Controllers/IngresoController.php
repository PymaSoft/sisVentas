<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\IngresoFormRequest;
use sisVentas\Ingreso;
use sisVentas\DetalleIngreso;
use DB;

use Carbon\Carbon; // Para utilizar el formato fecha-hora de nuestra zona horaria
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if ($request)
    	{
    		$query=trim($request->get('searchText'));
            $ingresos=DB::table('ingreso as i')
                ->join('persona as p','i.prov_id','=','p.per_id')
                ->join('detalle_ingreso as di','i.ing_id','=','di.ing_id')
                ->select('i.ing_id','i.ing_fecha','p.per_nombre','i.ing_tipocomprob','i.ing_seriecomprob','i.ing_numcomprob','i.ing_impuesto','i.ing_estado',DB::raw('sum(di.det_i_cantidad*det_i_preciocompra) as total'))
                ->where('i.ing_numcomprob','LIKE','%'.$query.'%')
                ->orderBy('i.ing_id','desc')
                ->groupBy('i.ing_id','i.ing_fecha','p.per_nombre','i.ing_tipocomprob','i.ing_seriecomprob','i.ing_numcomprob','ing_impuesto','i.ing_estado')
                ->paginate(7);
                return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	$personas=DB::table('persona')->where('per_tipo','=','Proveedor')->get();
        $articulos=DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.art_codigo, " ",art.art_nombre) AS articulo'),'art.art_id')
            ->where('art.art_estado','=','Activo')->get();
        return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);
    }
    
    public function store(IngresoFormRequest $request)          //Almacenar o Grabar
    {
    	try
        {
            DB::beginTransaction();
            $ingreso=new Ingreso;
            $ingreso->prov_id=$request->get('prov_id');
            $ingreso->ing_tipocomprob=$request->get('ing_tipocomprob');
            $ingreso->ing_seriecomprob=$request->get('ing_seriecomprob');
            $ingreso->ing_numcomprob=$request->get('ing_numcomprob');
            
            $mytime = Carbon::now('America/Bogota');
            $ingreso->ing_fecha=$mytime->toDateTimeString();
            $ingreso->ing_impuesto='19';
            $ingreso->ing_estado='A';
            $ingreso->save();
            // Tenemos que grabar el detalle de ese ingreso:
            $art_id = $request->get('art_id');
            $det_i_cantidad = $request->get('det_i_cantidad');
            $det_i_preciocompra = $request->get('det_i_preciocompra');
            $det_i_precioventa = $request->get('det_i_precioventa');
            
            $cont = 0;
            while($cont < count($art_id))
            {
                $detalle = new DetalleIngreso();
                $detalle->ing_id= $ingreso->ing_id;
                $detalle->art_id= $art_id[$cont];
                $detalle->det_i_cantidad= $det_i_cantidad[$cont];
                $detalle->det_i_preciocompra= $det_i_preciocompra[$cont];
                $detalle->det_i_precioventa= $det_i_precioventa[$cont];
                $detalle->save();                
                $cont=$cont+1;
            }
            
            DB::commit();
            
        } catch(\Exception $e)
        {
            DB::rollback();
        }
        
        return Redirect::to('compras/ingreso');
    }
    
    public function show($id)       // Mostramos un Ingreso específico ($id) con sus detalles
    {
        $ingreso=DB::table('ingreso as i')
            ->join('persona as p','i.prov_id','=','p.per_id')
            ->join('detalle_ingreso as di','i.ing_id','=','di.ing_id')
            ->select('i.ing_id','i.ing_fecha','p.per_nombre','i.ing_tipocomprob','i.ing_seriecomprob','i.ing_numcomprob','i.ing_impuesto','i.ing_estado',DB::raw('sum(di.det_i_cantidad*det_i_preciocompra) as total'))
            ->where('i.ing_id','=',$id)
            ->first();

        $detalles=DB::table('detalle_ingreso as d')
        ->join('articulo as a','d.art_id','=','a.art_id')
        ->select('a.art_nombre as articulo','d.det_i_cantidad','d.det_i_preciocompra','d.det_i_precioventa')
        ->where('d.ing_id','=',$id)
        ->get();
        return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }

    public function destroy($id)            // Cancelación del ingreso
    {
         $ingreso=Ingreso::findOrFail($id);  
         $ingreso->ing_estado='C';
         $ingreso->update();
         return Redirect::to('compras/ingreso');
    }
}