@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Proveedor: {{$persona->per_nombre}}</h3>
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
		{!!Form::model($persona,['method'=>'PATCH','route'=>['compras.proveedor.update',$persona->per_id]])!!}
		{{Form::token()}}
		<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="per_nombre">Nombre</label>
				<input type="text" name="per_nombre" required value="{{$persona->per_nombre}}" class="form-control" placeholder="Nombre...">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="per_direccion">Dirección</label>
				<input type="text" name="per_direccion" value="{{$persona->per_direccion}}" class="form-control" placeholder="Dirección...">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label>Doc.</label>
				<select name="per_tipodoc" class="form-control">
					@if ($persona->per_tipodoc=='CC')
						<option value="CC" selected>Cédula Ciudadanía</option>
						<option value="CE">Cédula Extranjería</option>
						<option value="RUT">Registro Único Tributario</option>
						<option value="PAS">Pasaporte</option>
					@elseif ($persona->per_tipodoc=='CE')
						<option value="CC">Cédula Ciudadanía</option>
						<option value="CE" selected>Cédula Extranjería</option>
						<option value="RUT">Registro Único Tributario</option>
						<option value="PAS">Pasaporte</option>
					@elseif ($persona->per_tipodoc=='RUT')
						<option value="CC">Cédula Ciudadanía</option>
						<option value="CE">Cédula Extranjería</option>
						<option value="RUT" selected>Registro Único Tributario</option>
						<option value="PAS">Pasaporte</option>
					@else
						<option value="CC">Cédula Ciudadanía</option>
						<option value="CE">Cédula Extranjería</option>
						<option value="RUT">Registro Único Tributario</option>
						<option value="PAS" selected>Pasaporte</option>
					@endif
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="per_numdoc">Num. Doc.</label>
				<input type="text" name="per_numdoc" required value="{{$persona->per_numdoc}}" class="form-control" placeholder="Número del Documento...">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="per_telefono">Teléfono</label>
				<input type="text" name="per_telefono" value="{{$persona->per_telefono}}" class="form-control" placeholder="Número Telefónico...">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="per_celular">Celular</label>
				<input type="text" name="per_celular" value="{{$persona->per_celular}}" class="form-control" placeholder="Número Celular...">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="per_email">Email</label>
				<input type="text" name="per_email" value="{{$persona->per_email}}" class="form-control" placeholder="Email...">
			</div>	
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!!Form::close()!!}
@endsection