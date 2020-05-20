<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\ArticuloFormRequest;
use sisVentas\Articulo;
use DB;

class ArticuloController extends Controller
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
    		$articulos=DB::table('articulo as a')
    		->join('categoria as c','a.cat_id','=','c.cat_id')
    		->select('a.art_id','a.art_nombre','a.art_codigo','a.art_stock','c.cat_nombre as categoria','a.art_descripcion','a.art_imagen','a.art_estado')
    		->where('a.art_nombre','LIKE','%'.$query.'%')
            ->orwhere('a.art_codigo','LIKE','%'.$query.'%')
    		->orderBy('art_id','desc')
    		->paginate(7);
    		return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]);
    	}
	}
	
    public function create()
    {
    	$categorias=DB::table('categoria')->where('cat_condicion','=','1')->get();
    	return view("almacen.articulo.create",["categorias"=>$categorias]);
	}
	
    public function store(ArticuloFormRequest $request)
    {
        $articulo= new Articulo;
    	$articulo->cat_id=$request->get('cat_id');
    	$articulo->art_codigo=$request->get('art_codigo');
    	$articulo->art_nombre=$request->get('art_nombre');
    	$articulo->art_stock=$request->get('art_stock');
    	$articulo->art_descripcion=$request->get('art_descripcion');
    	$articulo->art_estado='Activo';

    	if(Input::hasFile('art_imagen'))
    	{
    		$file=Input::file('art_imagen');
    		$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
    		$articulo->art_imagen=$file->getClientOriginalName();	
    	}
    	$articulo->save();
    	return Redirect::to('almacen/articulo');
	}
	
    public function show($id)
    {	
    	return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]);
	}
	
    public function edit($id)
    {
    	$articulo=Articulo::findOrFail($id);
    	$categoria=DB::table('categoria')->where('cat_condicion','=','1')->get();
    	return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categoria]);
	}
	
    public function update(ArticuloFormRequest $request,$id)
    {
    	$articulo=Articulo::findOrFail($id);
    	$articulo->cat_id=$request->get('cat_id');
    	$articulo->art_codigo=$request->get('art_codigo');
    	$articulo->art_nombre=$request->get('art_nombre');
    	$articulo->art_stock=$request->get('art_stock');
    	$articulo->art_descripcion=$request->get('art_descripcion');

    	if(Input::hasFile('art_imagen'))
    	{
    		$file=Input::file('art_imagen');
    		$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
    		$articulo->art_imagen=$file->getClientOriginalName();	
    	}
    	$articulo->update();
    	return Redirect::to('almacen/articulo');
	}
	
    public function destroy($id)
    {
    	$articulo=Articulo::findOrFail($id);
    	$articulo->art_estado='Inactivo';
    	$articulo->update();
    	return Redirect::to('almacen/articulo');
    }
}