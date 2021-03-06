@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	@include('reportes.header')
	<div id="filtros" class="col-xs-12">
		@include('reportes.filtros')	
	</div>
	<div id="reporte" data-id="{{Auth::user()->id_provincia}}" style="display:none;">
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
		
		$('#filtrar').on('click',function (event) {
			event.preventDefault();
			console.log("click");

			$('#reporte').show();

			$('#reporte-table').DataTable({			
				destroy: true,
				ajax : {
					url: 'query',
					data: {
						id_reporte : {{$reporte->id_reporte}},
						filtros: getFiltrosReportes(),
					}
				},
				columns: [
				{ data: 'periodo', title: 'Periodo'},
				{ data: 'provincia', title: 'Jurisdicción'},
				{ data: 'cantidad_planificadas', title: 'Cantidad de Acciones Planificadas'},
				{ data: 'cantidad_ejecutadas', title: 'Cantidad de Acciones Ejecutadas'},
				{ data: 'porcentaje', title: 'Porcentaje de Acciones Ejecutadas sobre total Planificado',
					render: function(data) {
						return '<div class="progress" style="height: 1.45rem;">'+
									'<div class="progress-bar" style="width:'+data+'%; background-color:#00C0EF !important; background-image:-webkit-linear-gradient(top,#00C0EF 0,#00C0EF 100%)!important;">'+
									'<p style="color:black; line-height: 1.4;"><b>'+data+'%</b></p>'+
									'</div>'+
								'</div>';
					}
				}
				]
			});	

		});		

		$('.excel').on('click',function (event) {
			event.preventDefault();

			mostrarDialogDescarga();
			var order_by = $('#reporte-table').DataTable().order();

			$.ajax({
				url: 'excel',
				data: {
					id_reporte : {{$reporte->id_reporte}},
					filtros: getFiltrosReportes(),
					order_by: order_by
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

