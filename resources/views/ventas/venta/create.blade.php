@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Venta</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
	{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-sx-12">
			<div class="form-group">
				<label for="cliente">Cliente</label>
				<select name="cli_id" id="cli_id" class="form-control selectpicker" data-live-search="true">
					@foreach($personas as $persona)
					<option value="{{$persona->per_id}}">{{$persona->per_nombre}}</option>
					@endforeach
				</select>
			</div>	
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<select name="ven_tipocomprob" class="form-control">
						<option value="Boleta">Boleta</option>
						<option value="Factura">Factura</option>
						<option value="Ticket">Ticket</option>
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label for="ven_seriecomprob">Serie Comprobante</label>
				<input type="text" name="ven_seriecomprob" value="{{old('ven_seriecomprob')}}" class="form-control" placeholder="Serie del Comprobante...">
			</div>	
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label for="ven_numcomprob">Número Comprobante</label>
				<input type="text" name="ven_numcomprob" required value="{{old('ven_numcomprob')}}" class="form-control" placeholder="Número del Comprobante...">
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
					<div class="form-group">
						<label for="art_id">Artículo</label>
						<select name="part_id" class="form-control selectpicker" id="part_id" data-live-search="true">
							@foreach($articulos as $articulo)
							<option value="{{$articulo->art_id}}_{{$articulo->art_stock}}_{{$articulo->precio_promedio}}">{{$articulo->articulo}}</option>	
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="det_v_cantidad">Cantidad</label>
						<input type="number" name="pdet_v_cantidad" id="pdet_v_cantidad" class="form-control" placeholder="cantidad">	
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="art_stock">Stock</label>
						<input type="number" disabled name="part_stock" id="part_stock" class="form-control" placeholder="stock">	
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="det_v_precioventa">Precio Venta</label>
						<input type="number" disabled name="pdet_v_precioventa" id="pdet_v_precioventa" class="form-control" placeholder="precio venta">
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="det_v_descuento">Descuento</label>
						<input type="number" name="pdet_v_descuento" id="pdet_v_descuento" class="form-control" placeholder="descuento">
					</div>
				</div>
				
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
					</div>
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 col-sx-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Opciones</th>
							<th>Artículo</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
							<th>Descuento</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th>TOTAL</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">$ 0.00</h4> <input type="hidden" name="ven_totalventa" id="ven_totalventa"></th>
						</tfoot>
						<tbody> 
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12" id="guardar">
			<div class="form-group">
				<input name="_token" value="{{ csrf_token() }}" type="hidden"></input>
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>				
	{!!Form::close()!!}
	@push ('scripts')
	<script>
		$(document).ready(function()
		{
			$('#bt_add').click(function()
			{
				agregar();
			});
		});
		var cont = 0;
		total = 0;
		subtotal = [];
		$("#guardar").hide();
		$("#part_id").change(mostrarValores);

		function mostrarValores()
		{
			datosArticulo=document.getElementById('part_id').value.split('_');
			$("#pdet_v_precioventa").val(datosArticulo[2]);
			$("#part_stock").val(datosArticulo[1]);
		}

		function agregar()
		{
			datosArticulo=document.getElementById('part_id').value.split('_');
			art_id=datosArticulo[0];
			articulo=$("#part_id option:selected").text();
			det_v_cantidad=$("#pdet_v_cantidad").val();
			det_v_descuento=$("#pdet_v_descuento").val(); 
			det_v_precioventa=$("#pdet_v_precioventa").val();
			art_stock=$("#part_stock").val();
 
			if (art_id!="" && det_v_cantidad!="" && det_v_cantidad>0 && det_v_descuento!="" && det_v_precioventa!="")
			{
				if(art_stock>=det_v_cantidad)
				{
					subtotal[cont]=(det_v_cantidad*det_v_precioventa - det_v_descuento);
					total=total+subtotal[cont];

					var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="art_id[]" value="'+art_id+'">'+articulo+'</td><td><input type="number" name="det_v_cantidad[]" value="'+det_v_cantidad+'"></td><td><input type="number" name="det_v_precioventa[]" value="'+det_v_precioventa+'"><td><input type="number" name="det_v_descuento[]" value="'+det_v_descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';
					cont++;
					limpiar();
					$("#total").html("$ " + total);
					$("#ven_totalventa").val(total);
					evaluar();
					$('#detalles').append(fila);
				}
				else
				{
					alert ('La cantidad a vender supera el stock');
				}
			}
			else 
			{
				alert("Error al ingresar el detalle de la venta, revise los datos del artículo");
			}
		}

		function limpiar()
		{
			$("#pdet_v_cantidad").val("");
			$("#pdet_v_descuento").val("");
			$("#pdet_v_precioventa").val("");
		}

		function evaluar()
		{
			if (total > 0)
			{
				$("#guardar").show();
			}
			else
			{
				$("#guardar").hide();
			}
		}

		function eliminar(index)
		{
			total=total-subtotal[index];
			$("#total").html("$ " + total);
			$("#ven_totalventa").val(total);
			$("#fila" + index).remove();	
			evaluar();
		}
	</script>
	@endpush
@endsection