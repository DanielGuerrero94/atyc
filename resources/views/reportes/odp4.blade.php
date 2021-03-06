@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		@include('reportes.header')
		<div id="filtros" class="col-xs-12">
			@include('reportes.filtros')	
		</div>	
	</div>	
	<div class="row">
		<div id="reporte" data-id-provincia="{{$provincia_usuario->id}}" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">
			{{ csrf_field() }}
			<div class="box box-info ">
				<div class="box-header">
					<h3 class="box-tittle">Reporte
						<div class="btn-group pull-right ">
							<a href="#" class="btn btn-square excel" title="Excel"><i class="fa fa-file-excel-o text-success fa-lg"> Excel</i></a>
						</div>	
					</h3>
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
		
		var table;	

		$('#filtrar').on('click',function () {

			$('#reporte').show();

			table = $('#reporte-table').DataTable({	
				destroy: true,
				searching: false,
				ordering: false,		
				ajax : {
					url: 'query',
					data: {
						id_reporte : {{$reporte->id_reporte}},
						filtros: getFiltrosReportes()
					}
				},
				columns: [
				{ data: 'periodo', title: 'Período'},
				{ data: 'provincia', title: 'Jurisdicción'},
				{ data: 'cantidad_alumnos', title: 'Cantidad de participantes'}
				]
			});

		});

		$('.excel').on('click',function () {

			mostrarDialogDescarga();

			$.ajax({
				url: 'excel',
				data: {
					id_reporte: {{$reporte->id_reporte}},
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

		$('.pdf').on('click',function () {			

			mostrarDialogDescarga();

			$.ajax({
				url: 'pdf',
				data: {
					id_reporte : {{$reporte->id_reporte}}, 
					filtros: getFiltrosReportes(),
					order_by : $('#reporte-table').DataTable().order()					
				},
				success: function(data){
					window.location="descargar/pdf/"+data;
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
