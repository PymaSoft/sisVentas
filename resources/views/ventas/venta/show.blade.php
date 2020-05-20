@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-sx-12">
			<div class="form-group">
				<label for="cliente">Cliente</label>
				<p>{{$venta->per_nombre}}</p>
			</div>	
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<p>{{$venta->ven_tipocomprob}}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label>Serie Comprobante</label>
				<p>{{$venta->ven_seriecomprob}}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-sx-12">
			<div class="form-group">
				<label>Número Comprobante</label>
				<p>{{$venta->ven_numcomprob}}</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="col-lg-12 col-sm-12 col-md-12 col-sx-12">
				<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
					<thead style="background-color:#A9D0F5">
							<th>Artículo</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
							<th>Descuento</th>
							<th>Subtotal</th>
					</thead> 
					<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">{{$venta->ven_totalventa}}</h4></th>
					</tfoot>
					<tbody>
						@foreach($detalles as $det)
						<tr>
							<td>{{$det->articulo}}</td>
							<td>{{$det->det_v_cantidad}}</td>
							<td>{{$det->det_v_precioventa}}</td>
							<td>{{$det->det_v_descuento}}</td>
							<td>{{$det->det_v_cantidad*$det->det_v_precioventa - $det->det_v_descuento}}</td>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>			

@endsection