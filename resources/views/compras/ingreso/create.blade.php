@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Ingreso</h3>
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
	{!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-sx-12">
			<div class="form-group">
				<label for="proveedor">Proveedor</label>
				<select name="prov_id" id="prov_id" class="form-control selectpicker" data-live-search="true">
					@foreach($personas as $persona)
					<option value="{{$persona->per_id}}">{{$persona->per_nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<select name="ing_tipocomprob" class="form-control">
						<option value="Boleta">Boleta</option>
						<option value="Factura">Factura</option>
						<option value="Ticket">Ticket</option>
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label for="ing_seriecomprob">Serie Comprobante</label>
				<input type="text" name="ing_seriecomprob" value="{{old('ing_seriecomprob')}}" class="form-control" placeholder="Serie del Comprobante...">
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label for="ing_numcomprob">Número Comprobante</label>
				<input type="text" name="ing_numcomprob" required value="{{old('ing_numcomprob')}}" class="form-control" placeholder="Número del Comprobante...">
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
							<option value="{{$articulo->art_id}}">{{$articulo->articulo}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="det_i_cantidad">Cantidad</label>
						<input type="number" name="pdet_i_cantidad" id="pdet_i_cantidad" class="form-control" placeholder="cantidad">
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="det_i_preciocompra">Precio Compra</label>
						<input type="number" name="pdet_i_preciocompra" id="pdet_i_preciocompra" class="form-control" placeholder="precio compra">
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-sx-12">
					<div class="form-group">
						<label for="det_i_precioventa">Precio Venta</label>
						<input type="number" name="pdet_i_precioventa" id="pdet_i_precioventa" class="form-control" placeholder="precio venta">
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
							<th>Precio Compra</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th>TOTAL</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">$ 0.00</h4></th>
						</tfoot>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12" id="guardar">
			<div class="form-group">
				<input name="_token" value="{{ csrf_token() }}" type="hidden"/>
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

		function agregar()
		{
			art_id=$("#part_id").val();
			articulo=$("#part_id option:selected").text();
			det_i_cantidad=$("#pdet_i_cantidad").val();
			det_i_preciocompra=$("#pdet_i_preciocompra").val();
			det_i_precioventa=$("#pdet_i_precioventa").val();

			if (art_id!="" && det_i_cantidad!="" && det_i_cantidad>0 && det_i_preciocompra!="" && det_i_precioventa!="")
			{
				subtotal[cont]=(det_i_cantidad*det_i_preciocompra);
				total=total+subtotal[cont];

				var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="art_id[]" value="'+art_id+'">'+articulo+'</td><td><input type="number" name="det_i_cantidad[]" value="'+det_i_cantidad+'"></td><td><input type="number" name="det_i_preciocompra[]" value="'+det_i_preciocompra+'"><td><input type="number" name="det_i_precioventa[]" value="'+det_i_precioventa+'"></td><td>'+subtotal[cont]+'</td></tr>';
				cont++;
				limpiar();
				$("#total").html("$ " + total);
				evaluar();
				$('#detalles').append(fila);
			}
			else
			{
				alert("Error al ingresar el detalle del ingreso, revise los datos del artículo");
			}
		}

		function limpiar()
		{
			$("#pdet_i_cantidad").val("");
			$("#pdet_i_preciocompra").val("");
			$("#pdet_i_precioventa").val("");
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
			$("#fila" + index).remove();
			evaluar();
		}
	</script>
	@endpush
@endsection