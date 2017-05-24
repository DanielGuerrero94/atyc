@extends('layouts.adminlte')
@section('content')
<div class="container">
	<div class="col-sm-12">
		<div class="box box-success ">
			<div class="box-header with-border">
				<h2 class="box-title">Curso</h2>
			</div>		
			<div class="box-body">
				<form class="form" role="form">	
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="form-group col-sm-12">          
						<label class="col-xs-2">Nombre:</label>
						<div class="typeahead__container col-xs-10">
							<div class="typeahead__field ">             
								<span class="typeahead__query ">
									<input class="nombre_typeahead " name="nombre" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off"
									value="{{$curso->nombre}}">
								</span>
							</div>
						</div>
					</div>	
					<div class="form-group col-sm-6">
						<label for="provincia" class="control-label col-sm-4">Provincia:</label>
						<div class="col-sm-8">
							<select class="form-control" id="provincia" name="provincia">

								<option data-id="{{$curso->id_provincia}}">{{$curso->provincia->nombre}}</option>

								@foreach ($provincias as $provincia)

								<option data-id="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>				 

								@endforeach
							</select>
						</div>
					</div>	
					<div class="form-group col-sm-6">
						<label for="area_tematica" class="control-label col-sm-4">Area tematica:</label>
						<div class="col-sm-8">
							<select class="form-control" id="area_tematica" name="area_tematica">

								<option data-id="{{$curso->id_area_tematica}}">{{$curso->area_tematica->nombre}}</option>

								@foreach ($areas_tematicas as $area)

								<option data-id="{{$area->id_area_tematica}}">{{$area->nombre}}</option>				 

								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label for="linea_estrategica" class="control-label col-sm-4">Linea Estrategica:</label>
						<div class="col-sm-8">
							<select class="form-control" id="linea_estrategica" name="linea_estrategica">

								<option data-id="{{$curso->id_linea_estrategica}}">{{$curso->linea_estrategica->nombre}}</option>

								@foreach ($lineas_estrategicas as $linea)

								<option data-id="{{$linea->id_linea_estrategica}}">{{$linea->nombre}}</option>				 

								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label for="edicion" class="control-label col-sm-4">Edicion:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="edicion" name="edicion" value="{{$curso->edicion}}" disabled>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label for="duracion" class="control-label col-sm-4">Duracion:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="duracion" name="duracion" value="{{$curso->duracion}}">
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="col-sm-3">Fecha:</label>

						<div class="input-group date col-sm-9">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" name="fecha" class="form-control pull-right" id="datepicker" value="{{$curso->fecha}}">
						</div>
					</div>
				</form>
			</div>		
			<div class="box-footer">
				<a href='{{url()->previous()}}'>
					<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
				</a>
				<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$curso->id_curso}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
			</div>
		</div> 
	</div>
	<div class="col-md-12">
		<div class="box box-info ">
			<div class="box-header">
				<h2 class="box-tittle">Alumnos</h2>
			</div>
			<div class="box-body">
				<table id="alumnos_del_curso" class="table table-hover">
					<thead>
						<tr>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Tipo Doc</th>
							<th>Nro Doc</th>
							<th>Provincia</th>
							<th>Acciones</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>

<script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js")}}" charset="UTF-8"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$.typeahead({
			input: '.nombre_typeahead',
			order: "desc",
			source: {
				info: {
					ajax: {
						type: "get",
						url: "cursos/nombres",
						path: "data.info"
					}
				}
			},
			callback: {
				onInit: function (node) {
					console.log('Typeahead Initiated on ' + node.selector);
				}
			}
		});

   //Date picker
   $('#datepicker').datepicker({
   	format: 'dd/mm/yyyy',
   	language: 'es',
   	autoclose: true
   });

   $(".box-footer").on("click","#volver",function(){
   	console.log('Se vuelve sin crear el curso.');
   	$('#alta').html("");
   	$('#abm').show();
   	$('#filtros').show();
   });

   $(".box-footer").on("click","#modificar",function(){

   	var curso = $(this).data('id');
   	var data = $('#alta form').serialize();
   	data += '&id_area_tematica='+$('#alta form #area_tematica :selected').data('id');
   	data += '&id_linea_estrategica='+$('#alta form #linea_estrategica :selected').data('id');
   	data += '&id_provincia='+$('#alta form #provincia :selected').data('id');


   	console.log(data);

   	$.ajax({
   		url: 'cursos/'+curso,
   		method: 'put',
   		data: data,
   		success: function(data){
   			console.log('Se modifico el curso correctamente.');
   			$('#alta').html("");
   			$('#abm').show();
   			$('#filtros').show();
   		},
   		error: function (data) {
   			console.log('Hubo un error.');
   			console.log(data);
   		}
   	});
   });

   $('#alumnos_del_curso').DataTable({
   	destroy: true,
   	ajax : $('#modificar').data('id')+'/alumnos',
   	columns: [
   	{ data: 'nombres'},
   	{ data: 'apellidos'},
   	{ data: 'tipo_doc'},
   	{ data: 'nro_doc'},
   	{ data: 'provincia'},
   	{ data: 'acciones'}
   	]
   }); 

});
</script>
@endsection