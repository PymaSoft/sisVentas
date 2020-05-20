<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaFormRequest;
use sisVentas\Venta;
use sisVentas\DetalleVenta;
use DB;

use Carbon\Carbon; // Para utilizar el formato fecha-hora de nuestra zona horaria
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
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
            $ventas=DB::table('venta as v')
                ->join('persona as p','v.cli_id','=','p.per_id')
                ->join('detalle_venta as dv','v.ven_id','=','dv.ven_id')
                ->select('v.ven_id','v.ven_fechahora','p.per_nombre','v.ven_tipocomprob','v.ven_seriecomprob','v.ven_numcomprob','v.ven_impuesto','v.ven_estado','v.ven_totalventa')
                ->where('v.ven_numcomprob','LIKE','%'.$query.'%')
                ->orderBy('v.ven_id','desc')
                ->groupBy('v.ven_id','v.ven_fechahora','p.per_nombre','v.ven_tipocomprob','v.ven_seriecomprob','v.ven_numcomprob','v.ven_impuesto','v.ven_estado')
                ->paginate(7);
                return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	$personas=DB::table('persona')->where('per_tipo','=','Cliente')->get();
        $articulos=DB::table('articulo as art')
        	->join('detalle_ingreso as di','art.art_id','=','di.art_id')
            ->select(DB::raw('CONCAT(art.art_codigo, " ",art.art_nombre) AS articulo'),'art.art_id','art.art_stock',DB::raw('avg(di.det_i_precioventa) as precio_promedio'))
            ->where('art.art_estado','=','Activo')
            ->where('art.art_stock','>','0')
            ->groupBy('articulo','art.art_id','art.art_stock')
            ->get();
        return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos]);
    }

    public function store(VentaFormRequest $request)  // Almacena o graba la venta y sus detalles de venta
    {
    	try
        {
            DB::beginTransaction();
            $venta=new Venta;
            $venta->cli_id=$request->get('cli_id');
            $venta->ven_tipocomprob=$request->get('ven_tipocomprob');
            $venta->ven_seriecomprob=$request->get('ven_seriecomprob');
            $venta->ven_numcomprob=$request->get('ven_numcomprob');
            $venta->ven_totalventa=$request->get('ven_totalventa');

            $mytime = Carbon::now('America/Bogota');
            $venta->ven_fechahora=$mytime->toDateTimeString();
            $venta->ven_impuesto='19';
            $venta->ven_estado='A';
            $venta->save();
            
            $art_id = $request->get('art_id');
            $det_v_cantidad = $request->get('det_v_cantidad');
            $det_v_descuento = $request->get('det_v_descuento');
            $det_v_precioventa = $request->get('det_v_precioventa');
            
            $cont = 0;
            while($cont < count($art_id))
            {
                $detalle = new DetalleVenta();
                $detalle->ven_id= $venta->ven_id;
                $detalle->art_id= $art_id[$cont];
                $detalle->det_v_cantidad= $det_v_cantidad[$cont];
                $detalle->det_v_descuento= $det_v_descuento[$cont];
                $detalle->det_v_precioventa= $det_v_precioventa[$cont];
                $detalle->save();                
                $cont=$cont+1;
            }
            
            DB::commit();
            
        } catch(\Exception $e)
        {
            DB::rollback();
        }
        
        return Redirect::to('ventas/venta');
    }
    
    public function show($id)
    {
        $venta=DB::table('venta as v')
            ->join('persona as p','v.cli_id','=','p.per_id')
            ->join('detalle_venta as dv','v.ven_id','=','dv.ven_id')
            ->select('v.ven_id','v.ven_fechahora','p.per_nombre','v.ven_tipocomprob','v.ven_seriecomprob','v.ven_numcomprob','v.ven_impuesto','v.ven_estado','v.ven_totalventa')
            ->where('v.ven_id','=',$id)
            ->first();

        $detalles=DB::table('detalle_venta as d')
        ->join('articulo as a','d.art_id','=','a.art_id')
        ->select('a.art_nombre as articulo','d.det_v_cantidad','d.det_v_descuento','d.det_v_precioventa')
        ->where('d.ven_id','=',$id)
        ->get();
        return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }

    public function destroy($id)
    {
         $venta=Venta::findOrFail($id);  
         $venta->ven_estado='C';
         $venta->update();
         return Redirect::to('ventas/venta');
    }
}
