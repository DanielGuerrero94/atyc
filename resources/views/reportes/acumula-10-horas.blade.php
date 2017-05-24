@extends('layouts.adminlte')

@section('content')
<div class="container">
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
					@if(Auth::user()->id_provincia == 25)
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
					@endif
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="periodo" class="control-label col-xs-2">Período:</label>
							<div class="col-xs-6">
								<select class="form-control" id="periodo">
									<option data-id="0" title="Todos los períodos">Todos los períodos</option>
									@foreach ($periodos as $periodo)
									<option data-id="{{$periodo->id_periodo}}" title="{{$periodo->nombre}}">{{$periodo->nombre}}</option>									
									@endforeach
								</select>
							</div>
						</div>						
					</div>
					<div class="row" id="toggle-fecha">
						<div class="form-group col-sm-6">
							<p>Especificar fecha:  <i class="fa fa-toggle-off btn"></i></p>
						</div>
					</div>
					<div class="row" style="display: none;">
						<div class="form-group col-sm-6">
							<label class="col-xs-2">Desde:</label>
							<div class="input-group date col-xs-8" style="width: 400px">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" name="desde" id="desde" class="form-control pull-right datepicker">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="col-xs-2">Hasta:</label>
							<div class="input-group date col-xs-8" style="width: 400px">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" name="hasta" id="hasta" class="form-control pull-right datepicker">
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">	
					<button class="btn btn-danger pull-right" id="limpiar" style="display: none"><i class="fa fa-eraser"></i>Limpiar</button>
					<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>				
				</div>
			</form>
		</div>
	</div>
	<div id="reporte" data-id-provincia="{{$provincia_usuario->id}}" style="display: none;">
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
								<th>Cantidad de alumnos</th>		
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

	$.unblockUI();

	$(document).ready(function(){
		var table;			

		$('#toggle-fecha').on('click',function () {

			var icono = $(this).find('i');

			switchIcon(icono,'fa-toggle-off','fa-toggle-on');
			
			var periodo = $('#periodo').closest('.row');
			var fecha = $('.fa-calendar').closest('.row');			
			
			showCalendarInputs(periodo,fecha);
		});		

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
			console.log(filtrosJson);

			$('#reporte').show();

			table = $('#reporte-table').DataTable({	
			destroy: true,		
			ajax : {
				url: 'query',
				data: {
					id_reporte : 1,
					filtros: filtros
				}
			},
			columns: [
			{ data: 'periodo'},
			{ data: 'provincia'},
			{ data: 'cantidad_alumnos'}
			]
		});
	
		});

		$('.excel').on('click',function () {

			var filtros = getFiltrosJson();
			console.log(filtros);
			var order_by = $('#reporte-table').DataTable().order();
			console.log(order_by);

			$.ajax({
				url: 'excel',
				data: {
					id_reporte: 1,
					filtros: filtros,
					order_by: order_by
				},
				success: function(data){
					alert('Se descargara pronto.');
					console.log(data);
					window.location="descargar/excel/"+data;
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
					console.log(data);
				}
			});
		});

		$('.pdf').on('click',function () {

			var filtros = getFiltrosJson();
			var order_by = $('#reporte-table').DataTable().order();			

			$.ajax({
				url: 'pdf',
				data: {
					id_reporte : 1, 
					filtros: filtros,
					order_by : order_by					
				},
				success: function(data){
					alert('Se descargara pronto.');
					console.log(data);
					window.location="descargar/pdf/"+data;
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
