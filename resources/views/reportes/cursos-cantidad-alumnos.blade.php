@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	@include('reportes.header')
	<div id="filtros" class="col-xs-12">
		@include('reportes.filtros')	
	</div>
	<div id="reporte" style="display:none;">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Reporte
						<div class="btn-group pull-right ">
							<a href="#" class="btn btn-square excel" title="Excel"><i class="fa fa-file-excel-o text-success fa-lg"> Excel</i></a>
						</div>	
					</h2>								
				</div>				
				<div class="box-body">
					<table id="reporte-table" class="table table-hover"/>
				</div>
			</div>
		</div>
	</div>	
</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){
		
		const ID_REPORTE = {{$reporte->id_reporte}};	
		
		$('#filtrar').on('click',function (event) {
			event.preventDefault();

			$('#reporte').show();

			$('#reporte-table').DataTable({			
				ajax : {
					url: 'query',
					data: {
						id_reporte : ID_REPORTE,
						filtros: getFiltrosReportes()
					}
				},
				destroy: true,
				columns: [
				{ data: 'periodo', title: 'Periodo'},
				{ data: 'provincia', title: 'Jurisdicción'},
				{ data: 'nombre', title: 'Nombre'},
				{ data: 'edicion', title: 'Edición'},
				{ data: 'fecha_ejec_inicial', title: 'Fecha'},
				{ data: 'cantidad_alumnos', title: 'Cantidad de participantes'},
				{ data: 'tipologia', title: 'Tipología de acción'},
				{ data: 'tematica', title: 'Area temática'},
				{ data: 'duracion', title: 'Duración'}
				]
			});	

		});		

		$('.excel').on('click',function (event) {
			event.preventDefault();
			mostrarDialogDescarga();

			$.ajax({
				url: 'excel',
				data: {
					id_reporte : ID_REPORTE,
                    filtros: getFiltrosReportes(),
                    order_by: $('#reporte-table').DataTable().order()
				},
				success: function(data){
					window.location="descargar/excel/"+data;
					$("#dialogDownload").remove();
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
				}
			});

		});

	});	

</script> 
@endsection

