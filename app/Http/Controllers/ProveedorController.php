<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\Persona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\PersonaFormRequest;
use DB;


class ProveedorController extends Controller
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
    		$personas=DB::table('persona')
    		->where('per_nombre','LIKE','%'.$query.'%')
    		->where('per_tipo','=','Proveedor')
    		->orwhere('per_numdoc','LIKE','%'.$query.'%')
    		->where('per_tipo','=','Proveedor')
    		->orderBy('per_id','desc')
    		->paginate(7);
    		return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query]);
    	}
	}
	
    public function create()
    {
    	return view("compras.proveedor.create");
	}
	
    public function store(PersonaFormRequest $request)
    {
        $persona= new Persona;
    	$persona->per_tipo='Proveedor';
    	$persona->per_nombre=$request->get('per_nombre');
    	$persona->per_tipodoc=$request->get('per_tipodoc');
    	$persona->per_numdoc=$request->get('per_numdoc');
    	$persona->per_direccion=$request->get('per_direccion');
    	$persona->per_telefono=$request->get('per_telefono');
    	$persona->per_celular=$request->get('per_celular');
    	$persona->per_email=$request->get('per_email');
    	$persona->save();
    	return Redirect::to('compras/proveedor');
	}
	
    public function show($id)
    {	
    	return view("compras.proveedor.show",["persona"=>Persona::findOrFail($id)]);
	}
	
    public function edit($id)
    {
    	return view("compras.proveedor.edit",["persona"=>Persona::findOrFail($id)]);
	}
	
    public function update(PersonaFormRequest $request,$id)
    {
    	$persona=Persona::findOrFail($id);
    	$persona->per_nombre=$request->get('per_nombre');
    	$persona->per_tipodoc=$request->get('per_tipodoc');
    	$persona->per_numdoc=$request->get('per_numdoc');
    	$persona->per_direccion=$request->get('per_direccion');
    	$persona->per_telefono=$request->get('per_telefono');
    	$persona->per_celular=$request->get('per_celular');
    	$persona->per_email=$request->get('per_email');    	
    	$persona->update();
    	return Redirect::to('compras/proveedor');
	}
	
    public function destroy($id)
    {
    	$persona=Persona::findOrFail($id);
    	$persona->per_tipo='Inactivo';
    	$persona->update();
    	return Redirect::to('compras/proveedor');
    }
}
