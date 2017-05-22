@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros" style="display: none;"></div>
	<div id="abm">
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Efectores
					<i class="fa fa-info-circle btn text-primary pull-right" title="Solo consulta de los que tienen georeferenciamiento."></i></h2>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Provincia</th>
								<th>Siisa</th>
								<th>Cuie</th>
								<th>Nombre</th>
								<th>Denominación legal</th>
								<th>Departamento</th>
								<th>Localidad</th>
								<th>Codigo postal</th>
								<th>Ciudad</th>
								<th></th>
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

		$('.table').DataTable({
			ajax : 'efectores/tabla',
			columns: [
			{ data: 'provincia'},
			{ data: 'siisa'},
			{ data: 'cuie'},
			{ data: 'nombre'},
			{ data: 'denominacion_legal'},
			{ data: 'departamento'},
			{ data: 'localidad'},
			{ data: 'codigo_postal'},
			{ data: 'ciudad'},
			{ data: 'acciones'}
			]
		});
		
	});
	
</script> 
@endsection

