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
							<a href="http://170.150.155.102/sirge3/public/login" class="btn btn-square" title="Ver en SIRGE">
								<i class="fa fa-link text-primary fa-lg"> SIRGE</i>
							</a>
							<a href="#" class="btn btn-square" title="Solo consulta de los que tienen georeferenciamiento.">
								<i class="fa fa-info-circle text-primary fa-lg"></i>
							</a>
							<a href="#" class="btn btn-square filter" title="Filtro">
								<i class="fa fa-sliders text-info fa-lg"></i>
							</a>
							<a href="#" class="btn btn-square expand" title="Expandir">
								<i class="fa fa-expand text-info fa-lg"></i>
							</a>
							<a href="#" class="btn btn-square compress" title="Comprimir" style="display: none;">
								<i class="fa fa-compress text-info fa-lg"></i>
							</a>
						</div>
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

	function historialButton(cuie) {
		return '<a href="{{url("/efectores")}}/' + cuie + '/cursos" class="btn btn-circle" title="Historial"><i class="fa fa-calendar text-info fa-lg"></i></a>';
	}
	
	function getFiltros(){
			filtros = $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray()
			.map(function(obj) { 
				var r = {};
				r[obj.name] = obj.value;
				return r;
			});

			filtros.push({capacitados: $("#form-filtros #capacitados").data("check")});
			return filtros;
		}


	function createDatatable(){
	
	datatable = $('.table').DataTable({
			destroy: true,
			responsive: true,
			searching: false,
			ajax : {
					url: "{{url('/efectores/filtrar')}}",
					data: {
						filtros: getFiltros()
					}
				},
			columns: [
			{ name: 'id_provincia', data: 'provincia', title: 'Provincia'},
			{ data: 'siisa', title: 'Siisa'},
			{ data: 'cuie', title: 'Cuie'},
			{ data: 'nombre', title: 'Nombre', orderable: false},
			{ data: 'denominacion_legal', title: 'Denominación legal', orderable: false},
			{ name: 'id_departamento', data: 'departamento', title: 'Departamento', orderable: false},
			{ name: 'id_localidad', data: 'localidad', title: 'Localidad', orderable: false},
			{ data: 'codigo_postal', title: 'Codigo postal', orderable: false},
			{ data: 'ciudad', title: 'Ciudad', orderable: false},
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
					return historialButton(row.cuie);
				},
				orderable: false
			}
			]
		});
		
		return datatable;
	}

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

		datatable = createDatatable();
		$('#filtros').on('click','#filtrar',function () {
			console.log(getFiltros());

			datatable = createDatatable();
		});	

	});

</script> 
@endsection

