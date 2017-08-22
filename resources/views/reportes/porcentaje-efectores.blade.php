@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div id="filtros" class="col-xs-12">
		@include('reportes.filtros')
	</div>
	<div id="reporte" data-id-provincia="{{$provincia_usuario->id}}" style="display:none;">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h3 class="box-tittle">{{$reporte->nombre}}
						<div class="btn-group pull-right ">
							<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></button>
						</div>	
						</h3>
				</div>
				<div class="box-body">
					<table id="reporte-table" class="table table-hover">
						<thead>
							<tr>
								<th>Período</th>
								<th>Provincia</th>
								<th>Capacitados</th>
								<th>Total efectores</th>
								<th>Porcentaje</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>	
	<div id="alta" style="display: none;"></div>
</div>
@endsection

@section('script')
<script type="text/javascript">		

	$.unblockUI();

	$(document).ready(function(){
		var table;		

		function getFiltrosJson() {
			var id_provincia = $('#filtros #provincia :selected').data('id');
			var id_periodo,desde,hasta;

			if($('#toggle-fecha i').hasClass('fa-toggle-off')){
				id_periodo = $('#filtros #periodo :selected').data('id');
			}else{
				desde = $('#filtros #desde').val();
				hasta = $('#filtros #hasta').val();
			}

			var data = {id_provincia: id_provincia,id_periodo: id_periodo,desde: desde,hasta: hasta};
			return data;
		};

		$('#filtrar').on('click',function () {
			var filtros = getFiltrosJson();		

			$('#reporte').show();

			table = $('#reporte-table').DataTable({	
			destroy: true,		
			ajax : {
				url: 'query',
				data: {
					id_reporte : 4,
					filtros: filtros
				}
			},
			columns: [
			{ data: 'periodo'},
			{ data: 'provincia'},
			{ data: 'capacitados'},
			{ data: 'total'},
			{ data: 'porcentaje'}
			]
		});
	
		});

		$('.excel').on('click',function () {

			var filtros = getFiltrosJson();
			var order_by = $('#reporte-table').DataTable().order();
			
			mostrarDialogDescarga();

			$.ajax({
				url: 'excel',
				data: {
					id_reporte: 4,
					filtros: filtros,
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

		$('.pdf').on('click',function () {

			var filtros = getFiltrosJson();
			var order_by = $('#reporte-table').DataTable().order();	
			
			mostrarDialogDescarga();

			$.ajax({
				url: 'pdf',
				data: {
					id_reporte : 4, 
					filtros: filtros,
					order_by : order_by					
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




