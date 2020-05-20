@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Artículo: {{$articulo->art_nombre}}</h3>
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
		{!!Form::model($articulo,['method'=>'PATCH','route'=>['almacen.articulo.update',$articulo->art_id],'files'=>'true'])!!}
		{{Form::token()}}
		<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="art_nombre">Nombre</label>
				<input type="text" name="art_nombre" required value="{{$articulo->art_nombre}}" class="form-control">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label>Categoría</label>
				<select name="cat_id" class="form-control">
					@foreach ($categorias as $cat)
						@if ($cat->cat_id == $articulo->cat_id)
						<option value="{{$cat->cat_id}}" selected>{{$cat->cat_nombre}}</option>
						@else
							<option value="{{$cat->cat_id}}">{{$cat->cat_nombre}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="art_codigo">Código</label>
				<input type="text" name="art_codigo" required value="{{$articulo->art_codigo}}" class="form-control">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="art_stock">Stock</label>
				<input type="text" name="art_stock" required value="{{$articulo->art_stock}}" class="form-control">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="art_descripcion">Descripción</label>
				<input type="text" name="art_descripcion" value="{{$articulo->art_descripcion}}" class="form-control" placeholder="DescripciÃ³n del artículo...">
			</div>	
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-sx-12">
			<div class="form-group">
				<label for="art_imagen">Imagen</label>
				<input type="file" name="art_imagen" class="form-control">
				@if (($articulo->art_imagen)!="")
					<img src="{{asset('imagenes/articulos/'.$articulo->art_imagen)}}" height="100px" width="100px">
				@endif
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