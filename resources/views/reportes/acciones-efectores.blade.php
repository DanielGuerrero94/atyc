@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div id="filtros" class="col-xs-12">
		@include('reportes.filtros')	
	</div>
	<div id="reporte" data-id="{{Auth::user()->id_provincia}}" style="display:none;">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">{{$reporte->nombre}}
						<div class="btn-group pull-right ">
							<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
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
		
		$('#filtrar').on('click',function (event) {
			event.preventDefault();

			$('#reporte').show();

			$('#reporte-table').DataTable({			
				destroy: true,
				ajax : {
					url: 'query',
					data: {
						id_reporte : {{$reporte->id_reporte}},
						filtros: getFiltrosReportes()
					}
				},
				columns: [
				{ data: 'periodo', title: 'Periodo'},
				{ data: 'provincia', title: 'Jurisdicción'},
				{ data: 'cuie', title: 'CUIE'},
				{ data: 'efector', title: 'Efector'},
				{ data: 'denominacion_legal', title: 'Denominación legal'},
				{ data: 'departamento', title: 'Departamento'},
				{ data: 'localidad', title: 'Localidad'},
				{ data: 'accion', title: 'Acción'},
				{ data: 'fecha', title: 'Fecha'},
				{ data: 'participantes', title: 'Paricipantes'}
				]
			});	

		});		

		$('.excel').on('click',function (event) {
			event.preventDefault();

			mostrarDialogDescarga();

			$.ajax({
				url: 'excel',
				data: {
					id_reporte : {{$reporte->id_reporte}},
					filtros: getFiltrosReportes()
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

