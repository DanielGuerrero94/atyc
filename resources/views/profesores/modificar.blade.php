@extends('layouts.adminlte')
@section('content')
<div class="container">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">Profesor</div>
			<div class="box-body">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
				<form id="form-alta">
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
							<label class="control-label col-xs-4" for="tipo_doc">Tipo de Documento:</label>
							<div class="col-xs-8">
								<select class="form-control" id="tipo_doc" title="Documento nacional de identidad" value="{{$profesor->id_tipo_documento}}">
									@foreach ($documentos as $documento)

									<option value="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>										
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
								<input name="tel" type="text" class="form-control" id="telefono" value="{{$profesor->tel}}">
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-4" for="cel">Cel:</label>
							<div class="col-xs-8">
								<input name="cel" type="text" class="form-control" id="cel" value="{{$profesor->cel}}">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
			<a href="{{url()->previous()}}">
				<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			</a>
				<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$profesor->id_profesor}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
			</div>
		</div> 
	</div>
	<div class="col-sm-12">
		<div class="box box-info collapsed-box">
			<div class="box-header with-border">
				<h2 class="box-title">Cursos dictados por el profesor</h2>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-plus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<table id="cursos-table" class="table table-hover" data-url="{{url('cursos/profesor')}}">
					<thead>
						<tr>
							<th>Nombre curso</th>
							<th>Fecha</th>
							<th>Provincia organizadora</th>
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

		$('#alta').on("click","#tipo_doc",function () {
			console.log($(this).find(":selected").attr("title"));
			console.log($('#alta').find("#tipo_doc").attr("title"));
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

		$('#alta #tipo_doc').val($('#alta #tipo_doc').attr('value'));

		//Si es un documento extranjero lo que tiene seteado muestro el pais del que corresponde
		var tipo_doc = $('#alta #tipo_doc').attr('value');
		if(tipo_doc == '6' || tipo_doc == '5'){
			
			$('#alta #pais').parent().parent().parent().parent().show();
		}

		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear el usuario.');
			$('#alta').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		var profesor = $('.container #modificar').data('id');

		$('#alta').on('click','#modificar',function () {
			var data = $('#alta form').serialize();
			data += '&_token='+$('#alta input').val();
			data += '&_method='+$('#alta input:nth-child(2)').val();
			data += '&id_tipo_doc='+$('#alta #tipo_doc').val();

			console.log(data);

			$.ajax({
				url: 'profesores/'+profesor,
				method: 'put',
				data: data,
				success: function(data){
					console.log('Se modificaron los datos del profesor correctamente.');
					$('#alta').html("");
					$('#abm').show();
					$('#filtros').show();
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
			{ data: 'nombre'},
			{ data: 'fecha'},
			{ data: 'provincia'},				
			{ data: 'acciones'}
			]
		});
		
	});
</script>
@endsection