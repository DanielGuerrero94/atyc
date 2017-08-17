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
					<h2 class="box-tittle">Acciones con participantes de efectores
						<div class="btn-group pull-right ">
							<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
							
						</div>	
					</h2>								
				</div>				
				<div class="box-body">
					<table id="reporte-table" class="table table-hover">
						<thead>
							<tr>							
								<th>Periodo</th>
								<th>Jurisdicción</th>
								<th>CUIE</th>
								<th>Efector</th>
								<th>Denominacion legal</th>
								<th>Departamento</th>
								<th>Localidad</th>
								<th>Accion</th>
								<th>Fecha</th>
								<th>Paricipantes</th>
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
				ajax : {
					url: 'query',
					data: {
						id_reporte : 6,
						filtros: getFiltrosJson()
					}
				},
				destroy: true,
				columns: [
				{ data: 'periodo'},
				{ data: 'provincia'},
				{ data: 'cuie'},
				{ data: 'efector'},
				{ data: 'denominacion_legal'},
				{ data: 'departamento'},
				{ data: 'localidad'},
				{ data: 'accion'},
				{ data: 'fecha'},
				{ data: 'participantes'}
				]
			});	

		}		

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
		
		$('#filtrar').on('click',function (event) {
			event.preventDefault();

			$('#reporte').show();

			var id_provincia = $('#filtros #provincia :selected').data('id');

			$('#reporte-table').DataTable({			
				ajax : {
					url: 'query',
					data: {
						id_reporte : 6,
						filtros: getFiltrosJson()
					}
				},
				destroy: true,
				columns: [
				{ data: 'periodo'},
				{ data: 'provincia'},
				{ data: 'cuie'},
				{ data: 'efector'},
				{ data: 'denominacion_legal'},
				{ data: 'departamento'},
				{ data: 'localidad'},
				{ data: 'accion'},
				{ data: 'fecha'},
				{ data: 'participantes'}
				]
			});	

		});		

		$('.excel').on('click',function (event) {
			event.preventDefault();

			$.ajax({
				url: 'excel',
				data: {
					id_reporte : 6,
					filtros: getFiltrosJson()
				},
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

