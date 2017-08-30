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
					<table class="table table-hover"/>
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
			destroy: true,
			responsive: true,
			searchable: false,
			ajax : 'efectores/tabla',
			columns: [
			{ name: 'id_provincia', data: 'provincia', title: 'Provincia',searchable: false, orderable: false},
			{ data: 'siisa', title: 'Siisa'},
			{ data: 'cuie', title: 'Cuie'},
			{ data: 'nombre', title: 'Nombre',searchable: false, orderable: false},
			{ data: 'denominacion_legal', title: 'Denominación legal',searchable: false, orderable: false},
			{ name: 'id_departamento', data: 'departamento', title: 'Departamento',searchable: false, orderable: false},
			{ name: 'id_localidad', data: 'localidad', title: 'Localidad',searchable: false, orderable: false},
			{ data: 'codigo_postal', title: 'Codigo postal',searchable: false, orderable: false},
			{ data: 'ciudad', title: 'Ciudad',searchable: false, orderable: false},
			{ data: 'acciones', title: 'Acciones', searchable: false, orderable: false}
			]
		});
		
	});
	
</script> 
@endsection

