@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row ">
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('efectores.filtros')
		</div>
	</div>
	<div class="row">
		<div id="abm">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Efectores
						<div class="btn-group pull-right" role="group" aria-label="...">
							<div type="button" class="btn btn-info filter" title="Filtro"><i class="fa fa-sliders"></i></div>
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

		$("#abm").on("click",".filter",function () {
			$("#filtros .box").toggle();
		});

		function getFiltros(){
			let filtros = $("#form-filtros :input")
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

		$("#filtros").on("click","#filtrar",function () {
			console.log(getFiltros());

			datatable = $(".table").DataTable({
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
				{ data: "provincia", name: "id_provincia", title: "Provincia", orderable: false},
				{ data: "siisa", title: "Siisa"},
				{ data: "cuie", title: "Cuie"},
				{ data: "nombre", title: "Nombre", orderable: false},
				{ data: "denominacion_legal", title: "Denominación legal", orderable: false},
				{ data: "departamento", name: "departamento", title: "Departamento", orderable: false},
				{ data: "localidad", name: "id_localidad", title: "Localidad", orderable: false},
				{ data: "codigo_postal", title: "Codigo postal", orderable: false},
				{ data: "ciudad", title: "Ciudad", orderable: false},
				{ data: "acciones", title: "Acciones", orderable: false}
				]
			});
		});	

		$(".container-fluid #filtros #filtrar").click();

	});

</script> 
@endsection

