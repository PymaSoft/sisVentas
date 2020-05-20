@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Listado de Artículos <a href="articulo/create"><button class="btn btn-success">Nuevo</button></a></h3>
		@include('almacen.articulo.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Código</th>
					<th>Categoría</th>
					<th>Stock</th>
					<th>Imagen</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($articulos as $art)
				<tr>
					<td>{{ $art->art_id}}</td>
					<td>{{ $art->art_nombre}}</td>
					<td>{{ $art->art_codigo}}</td>
					<td>{{ $art->categoria}}</td>
					<td>{{ $art->art_stock}}</td>
					<td>
						<img src="{{asset('imagenes/articulos/'.$art->art_imagen)}}" alt="{{ $art->art_nombre}}" height="100px" width="100px" class="img-thumbnail">
					</td>
					<td>{{ $art->art_estado}}</td>
					<td>
						<a href="{{URL::action('ArticuloController@edit',$art->art_id)}}"><button class="btn btn-info">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$art->art_id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('almacen.articulo.modal')
				@endforeach
			</table>
		</div>
		{{$articulos->render()}}
	</div>
</div>
@endsection