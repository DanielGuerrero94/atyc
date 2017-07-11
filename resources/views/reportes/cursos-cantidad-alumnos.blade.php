@extends('layouts.adminlte')

@section('content')
<div class="container">
	@if($provincia_usuario->id_provincia == 25)
	<div id="filtros" class="col-xs-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2 class="box-title">Filtros</h2>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<form id="form-filtros">
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="provincia" class="control-label col-xs-2">Provincia:</label>
							<div class="col-xs-6">
								<select class="form-control" id="provincia">
								<option data-id="0" title="Todas las provincias">Todas las provincias</option>
									@foreach ($provincias as $provincia)
									<option data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>							
									@endforeach
								</select>
							</div>
						</div>	
					</div>
				</div>
				<div class="box-footer">	
					<button class="btn btn-danger pull-right" id="limpiar" style="display: none"><i class="fa fa-eraser"></i>Limpiar</button>
					<button class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</button>				
				</div>
			</form>
		</div>
	</div>
	@endif
	<div id="reporte" data-id="{{$provincia_usuario->id_provincia}}" style="display:none;">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Reporte cursos de {{$provincia_usuario->nombre}}
						<div class="btn-group pull-right ">
							<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></button>
						</div>	
						</h2>								
				</div>				
				<div class="box-body">
					<table id="reporte-table" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Edicion</th>
								<th>Fecha</th>
								<th>Cantidad de alumnos</th>
								<th>Linea estrategica</th>
								<th>Area tematica</th>
								<th>Provincia</th>
								<th>Duracion</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>	
</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		var id_provincia = $('#reporte').data('id');

		if(id_provincia != 25){

			$('#reporte').show();

			$('#reporte-table').DataTable({			
			ajax : 'cursos/provincias/'+id_provincia+'/count',
			destroy: true,
			columns: [
			{ data: 'nombre'},
			{ data: 'edicion'},
			{ data: 'fecha'},
			{ data: 'cantidad_alumnos'},
			{ data: 'linea_estrategica'},
			{ data: 'area_tematica'},
			{ data: 'provincia'},
			{ data: 'duracion'}
			]
			});	

		}

		function getFiltrosJson() {
			var id_provincia = $('#filtros #provincia :selected').data('id');

			return {
				id_provincia: id_provincia
				};
		};

		$('#filtrar').on('click',function (event) {
			event.preventDefault();

			$('#reporte').show();

			var id_provincia = $('#filtros #provincia :selected').data('id');

			$('#reporte-table').DataTable({			
			ajax : 'cursos/provincias/'+id_provincia+'/count',
			destroy: true,
			columns: [
			{ data: 'nombre'},
			{ data: 'edicion'},
			{ data: 'fecha'},
			{ data: 'cantidad_alumnos'},
			{ data: 'linea_estrategica'},
			{ data: 'area_tematica'},
			{ data: 'provincia'},
			{ data: 'duracion'}
			]
			});	

		});		

		$('.excel').on('click',function () {
			var filtros = getFiltrosJson();	

			$.ajax({
				url: 'excel',
				data: {
					id_reporte : 6,
					filtros: filtros
				},
				success: function(data){
					window.location="descargar/"+data;
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
					console.log(data);
				}
			});
		});

		$('.pdf').on('click',function () {
			var filtros = getFiltrosJson();	

			$.ajax({
				url: 'pdf',
				data: {
					id_reporte : 6,
					filtros: filtros
				},
				success: function(data){
					window.location="descargar/"+data;
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
					console.log(data);
				}
			});
		});

	});
	
</script> 
@endsection

