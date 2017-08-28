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
				<form class="form form-modificacion" role="form">
					{{ csrf_field() }}
					{{ method_field('PUT') }}						
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="nombres" class="control-label col-sm-5">Nombres:</label>					
							<div class="col-sm-7">
								<input type="text" class="form-control" id="nombres" value="{{$alumno->nombres}}" name="nombres">
							</div>														
						</div>
						<div class="form-group col-sm-6">
							<label for="apellidos" class="control-label col-sm-3">Apellidos:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="apellidos" value="{{$alumno->apellidos}}" name="apellidos">
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="control-label col-sm-5" for="id_tipo_documento">Tipo de Documento:</label>
							<div class="col-sm-7">
								<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad" value="{{$alumno->id_tipo_documento}}" name="id_tipo_documento">
									@foreach ($documentos as $documento)

									<option value="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>

									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="nro_doc" class="control-label col-sm-3">Nro doc:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="nro_doc" value="{{$alumno->nro_doc}}" name="nro_doc">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6" id="nacionalidad" style="display: none">          
							<label class="control-label col-xs-2" for="pais">Pais:</label>
							<div class="typeahead__container col-xs-10">
								<div class="typeahead__field ">         
									<span class="typeahead__query ">
										<input class="pais_typeahead form-control" name="id_pais" type="search" placeholder="Buscar..." autocomplete="off" id="pais" value="{{$pais}}">
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
								<select class="form-control" id="provincia" value="{{$alumno->id_provincia}}" name="id_provincia"> 

									@foreach ($provincias as $provincia)								
									<option value="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>	

									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-sm-6">
							<label for="localidad" class="control-label col-sm-5">Localidad:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="localidad" value="{{$alumno->localidad}}" name="localidad">
							</div>
						</div>
					</div>	
					<hr>
					<div class="row">
						<div class="form-group">
							<label for="trabaja_en" class="control-label col-xs-2">Trabaja en:</label>
							<div class="col-xs-6">
								<select class="form-control" id="trabaja_en" value="{{$alumno->id_trabajo}}" name="id_trabajo">

									@foreach ($trabajos as $trabajo)

									@if ($alumno->id_trabajo == $trabajo->id_trabajo)
									<option value="{{$trabajo->id_trabajo}}" selected="selected" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>			
									@else
									<option value="{{$trabajo->id_trabajo}}" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>		
									@endif	

									@endforeach

								</select>
							</div>
						</div>
					</div>
					<br>
					<div class="row" >
						@if(isset($organismo->organismo1))
						<div class="form-group">
							@else
							<div class="form-group" style="display: none">
								@endif
								<label for="tipo_organismo" class="control-label col-xs-2">Organismo:</label>
								<div class="col-xs-6">
									<select class="form-control" name="organismo1" id="tipo_organismo">

										<option value="">Seleccionar</option>

										@foreach ($organismos as $organismo)
										@if ($alumno->organismo1 == $organismo->organismo1)
										<option title="{{$organismo->organismo1}}" selected="selected" value="{{$organismo->organismo1}}">{{$organismo->organismo1}}</option>	
										@else
										<option title="{{$organismo->organismo1}}" value="{{$organismo->organismo1}}">{{$organismo->organismo1}}</option>	
										@endif
										@endforeach							

									</select>
								</div>
							</div>
						</div>
						<br>
						<div class="row" >
							@if(isset($alumno->organismo1))
							<div class="form-group">
								@else
								<div class="form-group" style="display: none">
									@endif
									<label for="nombre_organismo" class="control-label col-xs-2">Nombre organismo:</label>
									<div class="col-xs-6">
										<input name="organismo2" type="text" class="form-control" id="nombre_organismo" value="{{$alumno->organismo2}}">
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								@if($alumno->id_trabajo == 2)
								<div class="form-group checkbox col-xs-12 col-sm-6">	
									@else
									<div class="form-group checkbox col-xs-12 col-sm-6" style="display: none;">	
										@endif
										<label for="tipo_convenio" class="control-label col-xs-4">Tipo convenio:</label>
										<div class="col-xs-8">
										@if(isset($alumno->establecimiento1))
											<input name="id_convenio" type="checkbox" id="tipo_convenio" checked="true">Convenio con el programa CUS SUMAR
											@else
											<input name="id_convenio" type="checkbox" id="tipo_convenio">Convenio con el programa CUS SUMAR
											@endif
										</div>
									</div>
								</div>
								<br>				
								<div class="row">
									@if(isset($alumno->establecimiento1))
									<div class="form-group">          
										@else
										<div class="form-group" style="display: none;">          
											@endif
											<label for="efectores" class="control-label col-xs-2">Efectores:</label>
											<div class="typeahead__container col-xs-6">
												<div class="typeahead__field">         
													<span class="typeahead__query">
														<input class="efectores_typeahead form-control" type="search" placeholder="Buscar..." autocomplete="off" id="efectores" value="{{$alumno->establecimiento1}}" name="establecimiento1">
													</span>
												</div>
											</div>
										</div>
									</div>
									<br>					
									<div class="row">
										@if(isset($alumno->establecimiento2))
										<div class="form-group">						
											@else
											<div class="form-group" style="display: none">
												@endif			
												<label for="establecimiento" class="control-label col-xs-2">Establecimiento:</label>
												<div class="col-xs-6">
													<input name="establecimiento" type="text" class="form-control" id="establecimiento" value="{{$alumno->establecimiento2}}" name="establecimiento2">
												</div>
											</div>
										</div>
										<br>
										<div class="row">
											@if(isset($alumno->id_funcion))
											<div class="form-group col-sm-6">
												@else
												<div class="form-group col-sm-6" style="display: none">
													@endif
													<label for="funcion" class="control-label col-sm-5">Rol con respecto al SUMAR:</label>
													<div class="col-sm-7">
														<select class="form-control" id="funcion" name="id_funcion">

															@foreach ($funciones as $funcion)
															@if ($alumno->id_funcion == $funcion->id_funcion)
															<option value="{{$funcion->id_funcion}}" title="{{$funcion->nombre}}" selected="selected">{{$funcion->nombre}}</option>		
															@else
															<option value="{{$funcion->id_funcion}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>
															@endif
															@endforeach

														</select>
													</div>
												</div>	
											</div>			
											<hr>
											<div class="form-group col-sm-4">
												<label for="email" class="control-label col-sm-3">Email:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" id="email" name="email" value="{{$alumno->email}}">
												</div>
											</div>
											<div class="form-group col-sm-4">
												<label for="telefono" class="control-label col-sm-3">Tel:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" id="telefono" name="tel" value="{{$alumno->tel}}">
												</div>
											</div>
											<div class="form-group col-sm-4">
												<label for="cel" class="control-label col-sm-3">Cel:</label>
												<div class="col-sm-7">
													<input type="text" class="form-control" id="cel" name="cel" value="{{$alumno->cel}}">
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
	

	$(document).ready(function () {

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
		
		//$('#id_tipo_documento').val($('#id_tipo_documento').attr('value'));

		//$('#provincia').val($('#provincia').attr('value'));
		
		//$('#trabaja_en').val($('#trabaja_en').attr('value'));

		//$('#funcion').val($('#funcion').attr('value'));

		var alumno = $('#modificar').data("id");
		var establecimiento = $('.container-fluid').find('#establecimiento').closest('.form-group');
		var efectores = $('.container-fluid').find('#efectores').closest('.form-group');

		$('.container-fluid').on("click","#trabaja_en",function (e) {

			$(this).attr("title",$(this).find(":selected").attr("title"));
			var tipo_organismo = $('.container-fluid').find('#tipo_organismo').closest('.form-group');
			var tipo_convenio = $('.container-fluid').find('#tipo_convenio').closest('.form-group');
			var nombre_organismo = $('.container-fluid').find('#nombre_organismo').closest('.form-group');
			var funcion = $('.container-fluid').find('#funcion').closest('.form-group');

			//Respeta los valores en la base de datos
			id_trabajo = parseInt($(this).val());

			switch (id_trabajo) {

				case 1:				
				tipo_organismo.hide();
				tipo_convenio.hide();
				$('.container-fluid').find('#tipo_convenio').prop('checked',false);
				nombre_organismo.hide();
				funcion.show();
				$('.container-fluid').find('#funcion').val(9).attr('disabled',true);
				establecimiento.hide();
				$('#establecimiento').attr('disabled',true);
				efectores.hide();
				$('#efectores').attr('disabled',true);
				break;

				case 2: 
				console.log('asd');
				tipo_convenio.show();				
				establecimiento.show();
				$('#establecimiento').attr('disabled',false);
				tipo_organismo.hide();
				nombre_organismo.hide();
				$('#nombre_organismo').attr('disabled',true);
				funcion.show();
				$('.container-fluid').find('#funcion').val(0).attr('disabled',false);
				break;

				case 3:
				tipo_organismo.show();
				nombre_organismo.show();
				$('#nombre_organismo').attr('disabled',false);
				funcion.show();
				$('.container-fluid').find('#funcion').val(0).attr('disabled',false);
				tipo_convenio.hide();
				$('.container-fluid').find('#tipo_convenio').prop('checked',false);
				establecimiento.hide();
				$('#establecimiento').attr('disabled',true);
				efectores.hide();
				$('#efectores').attr('disabled',true);
				break;

				default:
				tipo_organismo.hide();
				tipo_convenio.hide();
				$('.container-fluid').find('#tipo_convenio').prop('checked',false);
				nombre_organismo.hide();
				funcion.hide();
				establecimiento.hide();
				$('#establecimiento').attr('disabled',true);
				efectores.hide();
				$('#efectores').attr('disabled',true);
				break;
			}

		});

		$('.container-fluid').on('change','.checkbox',function () {			

			if(efectores.is(':hidden')){
				efectores.show();
				establecimiento.hide();
				$('#efectores').attr('disabled',false);
				$('#establecimiento').attr('disabled',true);
			}
			else{
				establecimiento.show();	
				efectores.hide();
				$('#establecimiento').attr('disabled',false);
				$('#efectores').attr('disabled',true);
			}

		});					

		$('.container-fluid').on("click","#id_tipo_documento",function () {
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('.container-fluid').find('#nacionalidad');
			if ($(this).val() == 5 || $(this).val() == 6 ) {
				nacionalidad.show();
				$('#pais').attr('disabled',false);
			}
			else {
				nacionalidad.hide();
				$('#pais').attr('disabled',true);
			}			
		});

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
							url : '{{url('alumnos')}}' + '/' + alumno,
							method : 'put',
							data : $('form').serialize(),
							success : function(data){
								console.log("Success.");
								window.location = "{{url('alumnos')}}";			
							},
							error : function(data){
								console.log("Error.");
								console.log(data);
								alert(JSON.stringify(data));
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