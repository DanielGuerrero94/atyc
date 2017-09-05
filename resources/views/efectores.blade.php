@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row ">
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('efectores.filtros')
		</div>
	</div>
	<div class="row">
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Efectores
						<div class="btn-group pull-right" role="group" aria-label="...">
							<!-- <div type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></div>
							<div type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></div> -->
							<div type="button" class="btn btn-info filter" title="Filtro"><i class="fa fa-sliders" aria-hidden="true"></i></div>
							<div type="button" class="btn btn-info expand" title="Expandir"><i class="fa fa-expand" aria-hiden="true"></i></div>
							<div type="button" class="btn btn-info compress" title="Comprimir" style="display: none;"><i class="fa fa-compress" aria-hidden="true"></i></div>	
						</div>
						<i class="fa fa-info-circle btn text-primary pull-right" title="Solo consulta de los que tienen georeferenciamiento."></i>
					</h2>
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

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').toggle();
		});

		$('#abm').on('click','.expand',function () {
			$('#abm').removeClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('#abm').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.expand').show();	
			$(this).hide();	
		});	

		datatable = $('.table').DataTable({
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

		function getFiltros(){
			return $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray()
			.map(function(obj) { 
				var r = {};
				r[obj.name] = obj.value;
				return r;
			});
		}

		$('#filtros').on('click','#filtrar',function () {
			console.log(getFiltros());

			datatable = $('.table').DataTable({
			destroy: true,
			responsive: true,
			searchable: false,
			ajax : {
				url: 'efectores/filtrar',
				data: {
					filtros: getFiltros()
				}
			},
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

	});

</script> 
@endsection

