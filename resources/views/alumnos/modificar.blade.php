@extends('layouts.adminlte')
@section('content')
<div class="container-fluid">	
	<div class="col-sm-12">
		<div class="box box-success ">
			<div class="box-header with-border">
				<h2 class="box-title">Participante</h2>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<form class="form" role="form">
					{{ csrf_field() }}
					{{ method_field('PUT') }}						
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="nombres" class="control-label col-sm-5">Nombres:</label>					
							<div class="col-sm-7">
								<input type="text" class="form-control" id="nombres" value="{{$alumno->nombres}}">
							</div>														
						</div>
						<div class="form-group col-sm-6">
							<label for="apellidos" class="control-label col-sm-3">Apellidos:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="apellidos" value="{{$alumno->apellidos}}">
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-5" for="id_tipo_documento">Tipo de Documento:</label>
							<div class="col-sm-7">
								<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad" value="{{$alumno->id_tipo_documento}}">
									@foreach ($documentos as $documento)

									<option value="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>

									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="nro_doc" class="control-label col-sm-3">Nro doc:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="nro_doc" value="{{$alumno->nro_doc}}">
							</div>
						</div>
					</div>
					<div class="row">
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
						<div class="form-group col-xs-12 col-sm-6">
						<label for="genero" class="control-label col-sm-5 col-xs-4">Genero:</label>
						<div class="col-sm-7 col-xs-8">
							<select class="form-control" id="genero" name="id_genero">
								<option>Seleccionar</option>

								@foreach ($generos as $genero)
								@if ($alumno->id_genero == $genero->id_genero)
								<option value="{{$genero->id_genero}}" selected="selected">{{$genero->nombre}}</option>
										@else
								<option value="{{$genero->id_genero}}">{{$genero->nombre}}</option>
										@endif	
								
								@endforeach
							</select>

						</div>
					</div>
					</div>
					<hr>
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="provincia" class="control-label col-sm-3">Provincia:</label>
							<div class="col-sm-7">
								<select class="form-control" id="provincia" value="{{$alumno->id_provincia}}">

									@foreach ($provincias as $provincia)								
									<option value="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>	

									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="localidad" class="control-label col-sm-5">Localidad:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="localidad" value="{{$alumno->localidad}}">
							</div>
						</div>
					</div>	
					<hr>
					<div class="row">
						<div class="form-group">
							<label for="trabaja_en" class="control-label col-xs-2">Trabaja en:</label>
							<div class="col-xs-6">
								<select class="form-control" id="trabaja_en" value="{{$alumno->id_trabajo}}">

									@foreach ($trabajos as $trabajo)

									<option value="{{$trabajo->id_trabajo}}" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>				 					
									@endforeach

								</select>
							</div>
						</div>
					</div>
					<br>
					<div class="row" >
						<div class="form-group" style="display: none">
							<label for="tipo_organismo" class="control-label col-xs-2">Organismo:</label>
							<div class="col-xs-6">
								<select class="form-control" name="tipo_organismo" id="tipo_organismo">

									<option>Seleccionar</option>

									@foreach ($organismos as $organismo)

									<option title="{{$organismo->organismo1}}">{{$organismo->organismo1}}</option>				 					
									@endforeach							

								</select>
							</div>
						</div>
					</div>
					<br>
					<div class="row" >
						<div class="form-group" style="display: none">
							<label for="nombre_organismo" class="control-label col-xs-2">Nombre organismo:</label>
							<div class="col-xs-6">
								<input name="organismo" type="text" class="form-control" id="nombre_organismo" value="{{$alumno->organismo2}}">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="form-group" style="display: none;">          
							<label for="efectores" class="control-label col-xs-2">Efectores:</label>
							<div class="typeahead__container col-xs-6">
								<div class="typeahead__field ">         
									<span class="typeahead__query ">
										<input class="efectores_typeahead form-control" name="efectores" type="search" placeholder="Buscar..." autocomplete="off" id="efectores" value="{{$alumno->establecimiento1}}">
									</span>
								</div>
							</div>
							<button type="button" class="btn btn-info filter" title="Filtro avanzado"><i class="fa fa-sliders" aria-hidden="true"></i></button>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="form-group" style="display: none">
							<label for="establecimiento" class="control-label col-xs-2">Establecimiento:</label>
							<div class="col-xs-6">
								<input name="establecimiento" type="text" class="form-control" id="establecimiento" value="{{$alumno->establecimiento2}}">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="form-group" style="display: none">
							<label for="funcion" class="control-label col-sm-4">Funcion que desempeña:</label>
							<div class="col-sm-8">
								<select class="form-control" id="funcion" value="{{$alumno->id_funcion}}">
									@foreach ($funciones as $funcion)

									<option value="{{$funcion->id_funcion}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>		
									@endforeach

								</select>
							</div>
						</div>	
					</div>			
					<hr>
					<div class="form-group col-sm-4">
						<label for="email" class="control-label col-sm-3">Email:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="email" value={{$alumno->email}}>
						</div>
					</div>
					<div class="form-group col-sm-4">
						<label for="telefono" class="control-label col-sm-3">Tel:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="telefono" value={{$alumno->tel}}>
						</div>
					</div>
					<div class="form-group col-sm-4">
						<label for="cel" class="control-label col-sm-3">Cel:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="cel" value={{$alumno->cel}}>
						</div>
					</div>
				</form>
			</div>		


			<div class="box-footer">
				<a href="{{url()->previous()}}"><button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button></a>
				<button class="btn btn-primary pull-right" id="modificar" title="Modificar" data-id="{{$alumno->id_alumno}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
			</div>
		</div> 
	</div>
	<div class="col-sm-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2 class="box-title">Acciones de capacitación a las que asistio</h2>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<table id="cursos-table" class="table table-hover" data-url="{{url('cursos/alumno')}}"/>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">

	//Typeahead para campos demasiado grandes como para traer una sola request
	$.typeahead({
		input: '#establecimiento',
		order: "desc",
		source: {
			info: {
				ajax: {
					type: "get",
					url: "alumnos/establecimientos",
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

	$.typeahead({
		input: '.efectores_typeahead',
		order: "desc",
		source: {
			cuie: {
				ajax: {
					type: "get",
					url: "efectores/typeahead",
					path: "data.cuie"
				}
			},
			nombre: {
				ajax: {
					type: "get",
					url: "efectores/typeahead",
					path: "data.nombre"
				}
			},
			siisa: {
				ajax: {
					type: "get",
					url: "efectores/typeahead",
					path: "data.siisa"
				}
			}
		},
		callback: {
			onInit: function (node) {
				console.log('Typeahead Initiated on ' + node.selector);
			}
		}
	});			

	$.typeahead({
		input: '#nombre_organismo',
		order: "desc",
		source: {
			info: {
				ajax: {
					type: "get",
					url: "alumnos/nombre_organismo",
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

	$(document).ready(function () {

		$('.container-fluid').on("click","#id_tipo_documento",function () {
			console.log($(this).find(":selected").attr("title"));
			console.log($('.container-fluid').find("#id_tipo_documento").attr("title"));
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('.container-fluid').find('#nacionalidad');
			if ($(this).val() == '6' || $(this).val() == '5' ) {
				nacionalidad.show();
			}
			else {
				nacionalidad.hide();
			}			
		});

		//Para setear como seleccionado lo que ya tiene seteado

		$('.container-fluid #id_tipo_documento').val($('.container-fluid #id_tipo_documento').attr('value'));

		//Si es un documento extranjero lo que tiene seteado muestro el pais del que corresponde
		var id_tipo_documento = $('.container-fluid #id_tipo_documento').attr('value');
		if(id_tipo_documento == '6' || id_tipo_documento == '5'){
			
			$('.container-fluid #pais').parent().parent().parent().parent().show();
		}
		
		$('#id_tipo_documento').val($('#id_tipo_documento').attr('value'));

		$('#provincia').val($('#provincia').attr('value'));
		
		$('#trabaja_en').val($('#trabaja_en').attr('value'));

		$('#funcion').val($('#funcion').attr('value'));

		var alumno = $('#modificar').data("id");

		$('.container-fluid').find('#cursos-table').DataTable({
			ajax : $('#cursos-table').data('url') + '/' + alumno,
			columns: [
			{ data: 'nombre', title: 'Nombre acción'},
			{ data: 'duracion', title: 'Horas duración'},
			{ data: 'provincia.nombre', title: 'Provincia organizadora'},
			{ data: 'acciones', title: 'Acciones'}
			]
		});

		$('.container-fluid').on("click","#modificar",function(){
			jQuery('<div/>', {
				id: 'dialogModificacion',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogModificacion").dialog({
				title: "Verificacion",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 360,
				height : 220,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					jQuery('<p/>', {
						id: 'dialogModificacion',
						text: '¿Esta seguro que quiere modificar al alumno?'
					}).appendTo('#dialogModificacion');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogModificacion").html("");

						$.ajax({				
							url : 'alumnos/'+alumno,
							method : 'put',
							data : $('form').serialize(),
							success : function(data){
								console.log("Success.");
								location.reload("true");			
							},
							error : function(data){
								console.log("Error.");
							}
						});

					},
					"Cancelar" : function () {
						$(this).dialog("destroy");
						$("#dialogModificacion").html("");
					}
				}				
			});			
		});

	});
</script>
@endsection