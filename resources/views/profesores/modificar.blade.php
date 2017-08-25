@extends('layouts.adminlte')
@section('content')
<div class="container">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">Docente</div>
			<div class="box-body">				
				<form id="form-alta">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="nombres" class="control-label col-xs-4">Nombres:</label>
							<div class="col-xs-8">
								<input name="nombres" type="text" class="form-control" id="nombres" value="{{$profesor->nombres}}">	
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="apellidos" class="control-label col-xs-4">Apellidos:</label>
							<div class="col-xs-8">
								<input name="apellidos" type="text" class="form-control" id="apellidos" value="{{$profesor->apellidos}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="id_tipo_documento">Tipo de Documento:</label>
							<div class="col-xs-8">
								<select class="form-control" id="id_tipo_documento" name="id_tipo_documento">
									@foreach ($tipoDocumento as $documento)							
										@if ($documento->id_tipo_documento == $profesor->id_tipo_documento)
										<option value="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}" selected="selected">{{$documento->nombre}}</option>
										@else
										<option value="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>
										@endif						
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="nro_doc">Nro doc:</label>
							<div class="col-xs-8">
								<input name="nro_doc" type="text" class="form-control" id="nro_doc" value="{{$profesor->nro_doc}}">
							</div>
						</div>
						<div class="form-group col-sm-6" id="nacionalidad" style="display: none">          
							<label class="control-label col-xs-2" for="pais">Pais:</label>
							<div class="typeahead__container col-xs-10">
								<div class="typeahead__field ">         
									<span class="typeahead__query ">
										<input class="pais_typeahead form-control" name="pais" type="search" placeholder="Buscar..." autocomplete="off" id="pais" value="{{$pais}}">
									</span>
								</div>
							</div>
						</div>					
					</div>	
					<hr>
				<div class="row">
				<div class="form-group col-sm-6">
						<label class="control-label col-xs-4" for="id_tipo_docente">Tipo de docente:</label>
						<div class="col-xs-8">
							<select class="form-control" id="id_tipo_docente" name="id_tipo_docente">
								@foreach ($tipoDocente as $tipo)
								
								@if ($tipo->id_tipo_docente == $profesor->id_tipo_docente)
								<option value="{{$tipo->id_tipo_docente}}" selected="selected">{{$tipo->nombre}}</option>
								@else
								<option value="{{$tipo->id_tipo_docente}}">{{$tipo->nombre}}</option>
								@endif				 
								
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<hr>
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="email">Email:</label>
							<div class="col-xs-8">
								<input name="email" type="text" class="form-control" id="email" value="{{$profesor->email}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="telefono">Telefono:</label>
							<div class="col-xs-8">
								<input name="tel" type="number" class="form-control" id="telefono" value="{{$profesor->tel}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="cel">Cel:</label>
							<div class="col-xs-8">
								<input name="cel" type="number" class="form-control" id="cel" value="{{$profesor->cel}}">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
			<a href="{{url()->previous()}}">
				<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			</a>
				<div class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$profesor->id_profesor}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</div>
			</div>
		</div> 
	</div>
	<div class="col-sm-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2 class="box-title">Acciones dictados por el docente</h2>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<table id="cursos-table" class="table table-hover" data-url="{{url('cursos/profesor')}}"/>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function () {

		$.typeahead({
			input: '.pais_typeahead',
			order: "desc",
			source: {
				info: {
					ajax: {
						type: "get",
						url: "paises/nombres",
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

		$('#alta').on("click","#id_tipo_documento",function () {
			console.log($(this).find(":selected").attr("title"));
			console.log($('#alta').find("#id_tipo_documento").attr("title"));
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('#alta').find('#nacionalidad');
			if ($(this).val() == '6' || $(this).val() == '5' ) {
				nacionalidad.show();
			}
			else {
				nacionalidad.hide();
			}			
		});

		//Para setear como seleccionado lo que ya tiene seteado

		$('#alta #id_tipo_documento').val($('#alta #id_tipo_documento').attr('value'));

		//Si es un documento extranjero lo que tiene seteado muestro el pais del que corresponde
		var id_tipo_documento = $('#alta #id_tipo_documento').attr('value');
		if(id_tipo_documento == '6' || id_tipo_documento == '5'){
			
			$('#alta #pais').parent().parent().parent().parent().show();
		}

		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear el usuario.');
			$('#alta').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		var profesor = $('.container #modificar').data('id');

		$(".container").on("click","#modificar",function () {
			var data = $('#form-alta').serialize();

			$.ajax({
				url: profesor,
				method: 'put',
				data: data,
				success: function(data){
					console.log('Se modificaron los datos del profesor correctamente.');
					$('#alta').html("");
					$('#abm').show();
					$('#filtros').show();
					window.location = "{{url('profesores')}}";
				},
				error: function (data) {
					console.log('Error.');
					console.log(data);
				}
			});

		});

		$('.container').find('#cursos-table').DataTable({
			ajax : $('#cursos-table').data('url') + '/' + profesor,
			columns: [
			{ data: 'nombre', title: 'Nombre accion'},
			{ data: 'fecha', title: 'Fecha'},
			{ data: 'provincia.nombre', title: 'Provincia organizadora'},				
			{ data: 'acciones', title: 'Acciones'}
			]
		});
		
	});
</script>
@endsection