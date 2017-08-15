@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros" class="col-xs-12">
		@include('reportes.filtros')	
	</div>
	<div id="reporte" data-id="{{$provincia_usuario->id_provincia}}" style="display:none;">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Cantidad de participantes por acción de capacitación
						<div class="btn-group pull-right ">
							<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
							
						</div>	
						</h2>								
				</div>				
				<div class="box-body">
					<table id="reporte-table" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Edición</th>
								<th>Fecha</th>
								<th>Cantidad de participantes</th>
								<th>Tipología de acción</th>
								<th>Area temática</th>
								<th>Jurisdicción</th>
								<th>Duración</th>
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
				url: 'excel6',
				data: {
					filtros: filtros,
					order_by: order_by 
				}
				success: function(data){
					window.location="descargar/excel/"+data;
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

