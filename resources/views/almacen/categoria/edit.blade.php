@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Categoría: {{$categoria->cat_nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
			{!!Form::model($categoria,['method'=>'PATCH','route'=>['almacen.categoria.update',$categoria->cat_id]])!!}
			{{Form::token()}}
			<div class="form-group">
				<label for="cat_nombre">Nombre</label>
				<input type="text" name="cat_nombre" class="form-control" value="{{$categoria->cat_nombre}}" placeholder="Nombre...">
			</div>
			<div class="form-group">
				<label for="cat_descripcion">Descripción</label>
				<input type="text" name="cat_descripcion" class="form-control" value="{{$categoria->cat_descripcion}}" placeholder="Descripción...">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
			{!!Form::close()!!}
		</div>
	</div>
@endsection