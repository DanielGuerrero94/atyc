<div class="box box-success">
	<div class="box-header">Alta de participante</div>
	<div class="box-body">
		<form id="form-alta">
			{{ csrf_field() }}
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label for="nombres" class="control-label col-xs-4">Nombres: </label>
					<div class="col-xs-8">
						<input name="nombres" type="text" class="form-control" id="nombres">
					</div>
				</div>
				<div class="form-group cols-xs col-sm-6">
					<label for="apellidos" class="control-label col-xs-4">Apellidos: </label>
					<div class="col-xs-8">
						<input name="apellidos" type="text" class="form-control" id="apellidos">
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label class="control-label col-xs-4" for="id_tipo_documento">Tipo de Documento: </label>
					<div class="col-xs-8">
						<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad" name="id_tipo_documento">
							@foreach ($documentos as $documento)

							<option data-id="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}" value="{{$documento->id_tipo_documento}}">{{$documento->nombre}}</option>

							@endforeach
						</select>
					</div>
				</div>
				<div id="numero_documento" class="form-group col-xs-12 col-sm-6">
					<label for="nro_doc" class="control-label col-xs-4">Nro doc:</label>
					<div class="col-xs-8">
						<input name="nro_doc" type="number" class="form-control" id="nro_doc">
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-6" id="nacionalidad" style="display: none">          
					<label class="control-label col-xs-4" for="pais">País:</label>
					<div class="typeahead__container col-xs-8">
						<div class="typeahead__field ">         
							<span class="typeahead__query ">
								<input class="pais_typeahead form-control" name="pais" type="search" placeholder="Buscar..." autocomplete="off" id="pais" disabled>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label for="genero" class="control-label col-xs-4">Genero:</label>
					<div class="col-xs-8">
						<select class="form-control" id="genero" name="id_genero">
							<option>Seleccionar</option>

							@foreach ($generos as $genero)

							<option value="{{$genero->id_genero}}">{{$genero->nombre}}</option>

							@endforeach
						</select>

					</div>
				</div>						
			</div>	
			<hr>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label for="provincia" class="control-label col-xs-4">Jurisdicción:</label>
					<div class="col-xs-8">
						@if(Auth::user()->id_provincia == 25)
						<select class="form-control" id="provincia" name="id_provincia">
							@foreach ($provincias as $provincia)

							<option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>									
							@endforeach
						</select>
						@else
						<select class="form-control" id="provincia" name="id_provincia" disabled>
							<option data-id="{{Auth::user()->id_provincia}}" value="{{Auth::user()->id_provincia}}">{{Auth::user()->name}}</option>	
						</select>
						@endif
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label for="localidad" class="control-label col-xs-4">Localidad:</label>
					<div class="col-xs-8">
						<input id="localidad" type="text" class="form-control" name="localidad" placeholder="Donde trabaja o desarrola su funcion">
					</div>
				</div>	
			</div>				
			<hr>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label for="trabaja_en" class="control-label col-xs-4">Trabaja en:</label>
					<div class="col-xs-8">
						<select class="form-control" id="trabaja_en" name="id_trabajo">

							<option data-id="0" value="0">Seleccionar</option>

							@foreach ($trabajos as $trabajo)

							<option data-id="{{$trabajo->id_trabajo}}" value="{{$trabajo->id_trabajo}}">{{$trabajo->nombre}}</option>				 					
							@endforeach

						</select>
					</div>
				</div>
			</div>
			<br>
			<div class="row" >
				<div class="form-group col-xs-12 col-sm-6" style="display: none;">
					<label for="tipo_organismo" class="control-label col-xs-4">Organismo:</label>
					<div class="col-xs-8">
						<select class="form-control" id="tipo_organismo" name="tipo_organismo">

							<option value="0">Seleccionar</option>

							@foreach ($organismos as $organismo)

							<option title="{{$organismo->organismo1}}">{{$organismo->organismo1}}</option>				 					
							@endforeach							

						</select>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6" style="display: none">  
					<label for="nombre_organismo" class="control-label col-xs-4">Nombre organismo:</label>					
					<div class="typeahead__container col-xs-8">
						<div class="typeahead__field ">         
							<span class="typeahead__query ">
								<input class="nombre_organismo_typeahead form-control" name="nombre_organismo" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" id="nombre_organismo" disabled>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group checkbox col-xs-12 col-sm-6" style="display: none;">	
					<label for="tipo_convenio" class="control-label col-xs-4">Tipo convenio:</label>
					<div class="col-xs-8">
						<input name="tipo_convenio" type="checkbox" id="tipo_convenio">Convenio con el programa CUS SUMAR
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6" id="efectores_field" style="display: none;">          
					<label for="efectores" class="control-label col-xs-4">Efectores:</label>
					<div class="typeahead__container col-xs-8">
						<div class="typeahead__field">         
							<span class="typeahead__query">
								<input class="efectores_typeahead form-control" name="efector" type="search" placeholder="Buscar..." autocomplete="off" id="efectores" disabled>
							</span>
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-default" id="ver_efectores" style="display: none;">Ver todos</button>
			</div>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6" id="establecimiento_field" style="display: none">          
					<label for="establecimiento" class="control-label col-xs-4">Establecimiento:</label>
					<div class="typeahead__container col-xs-8">
						<div class="typeahead__field">             
							<span class="typeahead__query">
								<input class="establecimiento_typeahead form-control" name="establecimiento" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" id="establecimiento" disabled>
							</span>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6" style="display: none;">
					<label for="funcion" class="control-label col-xs-4">Rol con respecto al SUMAR:</label>
					<div class="col-xs-8">
						<select class="form-control" id="funcion" name="id_funcion">

							<option data-id="1" value="0" title="Seleccionar">Seleccionar</option>

							@foreach ($funciones as $funcion)

							<option data-id="{{$funcion->id_funcion}}" value="{{$funcion->id_funcion}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>	

							@endforeach

						</select>
					</div>
				</div>	
			</div>					
			<hr>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-4">
					<label for="email" class="control-label col-xs-4">Email:</label>
					<div class="col-xs-8">
						<input name="email" type="email" class="form-control" id="email">
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-4">
					<label for="tel" class="control-label col-xs-4">Tel:</label>
					<div class="col-xs-8">
						<input name="tel" type="number" class="form-control" id="tel">
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-4">
					<label for="cel" class="control-label col-xs-4">Cel:</label>
					<div class="col-xs-8">
						<input name="cel" type="number" class="form-control" id="cel">
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i> Volver</div>
				<button class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus" aria-hidden="true"></i> Alta</button>
			</div>
		</form>
	</div>		
</div> 

<script type="text/javascript">

	$(document).ready(function () {
		
	//Typeahead para campos demasiado grandes como para traer una sola request
	function iniciarEstablecimientosTypeahead () {
		
		$.typeahead({
			input: '.establecimiento_typeahead',
			order: "desc",
			dynamic: true,
			source: {
				info: {
					ajax: {
						url: "alumnos/establecimientos",
						path: "data.info",						
						data: {
							q: "@{{query}}"
						},
						success: function(data){
							console.log("ajax success");
							console.log(data);							
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				}
			},
			callback: {
				onInit: function (node) {
					console.log('Typeahead Initiated on ' + node.selector);
				}
			}
		});
		
	}
	
	function iniciarEfectoresTypeahead () {
		
		$.typeahead({
			input: '.efectores_typeahead',
			maxItem: 15,
			order: "desc",
			dynamic: true,
			hint: true,
			backdrop: {
				"background-color": "#fff"
			},
			dropdownFilter: "Filtro",
			emptyTemplate: 'No hay resultados',
			source: {
				nombre: {
					ajax: {
						url: "efectores/nombres/typeahead",
						path: "data.nombres",						
						data: {
							q: "@{{query}}",
							id_provincia: $('#alta #form-alta #provincia').val()
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				cuie: {
					ajax: {
						url: "efectores/cuies/typeahead",
						path: "data.cuies",						
						data: {
							q: "@{{query}}",
							id_provincia: $('#alta #form-alta #provincia').val()
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
			},
			callback: {
				onInit: function (node) {
					console.log('Typeahead Initiated on ' + node.selector);
				}
			}
		});
		
	}				
	
	$.typeahead({
		input: '.nombre_organismo_typeahead',
		order: "desc",
		source: {
			info: {
				ajax: {
					url: "alumnos/nombre_organismo",
					path: "data.info",
					data: {
						q: "@{{query}}"
					},
					error: function(data){
						console.log("ajax error");
						console.log(data);
					}
				}
			}
		},
		callback: {
			onInit: function (node) {
				console.log('Typeahead Initiated on ' + node.selector);
			}
		}
	});
	
	$('#alta').on('click', '#ver_efectores', function(event) {
		event.preventDefault();			
	});
	
	var establecimiento = $('#alta').find('#establecimiento').closest('.form-group');
	var efectores = $('#alta').find('#efectores').closest('.form-group');
	
	$('#alta').on('click', '#provincia', function(event) {
		event.preventDefault();

		if ($('#efectores_field').is(':hidden')) {
			$('#establecimiento_field').empty();
			$('<label for="establecimiento" class="control-label col-xs-4">Establecimiento:</label><div class="typeahead__container col-xs-8"><div class="typeahead__field"><span class="typeahead__query"><input class="establecimiento_typeahead form-control" name="establecimiento" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" id="establecimiento"></span></div></div>').appendTo('#establecimiento_field');
			iniciarEstablecimientosTypeahead();
		} else {
			$('#efectores_field').empty();
			$('<label for="efectores" class="control-label col-xs-4">Efectores:</label><div class="typeahead__container col-xs-8"><div class="typeahead__field"><span class="typeahead__query"><input class="efectores_typeahead form-control" name="efector" type="search" placeholder="Buscar..." autocomplete="off" id="efectores"></span></div></div>').appendTo('#efectores_field');
			iniciarEfectoresTypeahead();
		}
		
	});
	
	/*Funciones para que aparezcan o desaparezcan campos en el
	formulario*/
	
	$('#alta').on("click","#trabaja_en",function (e) {
		
		$(this).attr("title",$(this).find(":selected").attr("title"));
		var tipo_organismo = $('#alta').find('#tipo_organismo').closest('.form-group');
		var tipo_convenio = $('#alta').find('#tipo_convenio').closest('.form-group');
		var nombre_organismo = $('#alta').find('#nombre_organismo').closest('.form-group');
		var funcion = $('#alta').find('#funcion').closest('.form-group');
		
		//Respeta los valores en la base de datos
		id_trabajo = parseInt($(this).val());
		
		switch (id_trabajo) {
			
			case 1:				
			tipo_organismo.hide();
			tipo_convenio.hide();
			$('#alta').find('#tipo_convenio').prop('checked',false);
			nombre_organismo.hide();
			funcion.show();
			$('#alta').find('#funcion').val(9).attr('disabled',true);
			establecimiento.hide();
			$('#establecimiento').attr('disabled',true);
			efectores.hide();
			$('#efectores').attr('disabled',true);
			break;
			
			case 2: 
			console.log('asd');
			tipo_convenio.show();				
			establecimiento.show();
			iniciarEstablecimientosTypeahead();				
			iniciarEfectoresTypeahead();
			$('#establecimiento').attr('disabled',false);
			tipo_organismo.hide();
			nombre_organismo.hide();
			$('#nombre_organismo').attr('disabled',true);
			funcion.show();
			$('#alta').find('#funcion').val(0).attr('disabled',false);
			break;
			
			case 3:
			tipo_organismo.show();
			nombre_organismo.show();
			$('#nombre_organismo').attr('disabled',false);
			funcion.show();
			$('#alta').find('#funcion').val(0).attr('disabled',false);
			tipo_convenio.hide();
			$('#alta').find('#tipo_convenio').prop('checked',false);
			establecimiento.hide();
			$('#establecimiento').attr('disabled',true);
			efectores.hide();
			$('#efectores').attr('disabled',true);
			break;
			
			default:
			tipo_organismo.hide();
			tipo_convenio.hide();
			$('#alta').find('#tipo_convenio').prop('checked',false);
			nombre_organismo.hide();
			funcion.hide();
			establecimiento.hide();
			$('#establecimiento').attr('disabled',true);
			efectores.hide();
			$('#efectores').attr('disabled',true);
			break;
		}
		
	});
	
	$('#alta').on('change','.checkbox',function () {			
		
		if (efectores.is(':hidden')) {		
			efectores.show();
			establecimiento.hide();
			$('#efectores').attr('disabled',false);
			$('#establecimiento').attr('disabled',true);
		} else {
			establecimiento.show();	
			efectores.hide();
			$('#establecimiento').attr('disabled',false);
			$('#efectores').attr('disabled',true);
		}
		
	});					
	
	$('#alta').on("click","#id_tipo_documento",function () {
		$(this).attr("title",$(this).find(":selected").attr("title"));
		var nacionalidad = $('#alta').find('#nacionalidad');
		if ($(this).val() == 5 || $(this).val() == 6 ) {
			nacionalidad.show();
			$('#pais').attr('disabled',false);
			
			$.typeahead({
				input: '.pais_typeahead',
				order: "desc",
				source: {
					info: {
						ajax: {
							url: "paises/nombres",
							path: "data.info",						
							data: {
								q: "@{{query}}"
							},
							error: function(data){
								console.log("ajax error");
								console.log(data);
							}
						}
					}
				},
				callback: {
					onInit: function (node) {
						console.log('Typeahead Initiated on ' + node.selector);
					}
				}
			});
			
		}
		else {
			nacionalidad.hide();
			$('#pais').attr('disabled',true);
		}			
	});
	
	/*funciones abm*/	
	function getSelected() {
		var id_tipo_documento = $('#alta #form-alta #id_tipo_documento :selected').data('id');
		var id_provincia = $('#alta #form-alta #provincia :selected').data('id');
		var id_trabajo = $('#alta #form-alta #trabaja_en :selected').data('id');
		var id_funcion = $('#alta #form-alta #funcion :selected').data('id');
		
		return [
		{	
			name: 'id_tipo_documento',
			value: id_tipo_documento
		},
		{	
			name: 'id_provincia',
			value: id_provincia
		},
		{	
			name: 'id_trabajo',
			value: id_trabajo
		},
		{	
			name: 'id_funcion',
			value: id_funcion
		}];
	}
	
	function getInput() {					
		return $.merge($('#alta #form-alta').serializeArray(),getSelected());
	}						
	
	/*Validaciones*/
	var tieneAlMenosSieteDigitos = new RegExp(/^\d{7,9}$/);

	jQuery.validator.addMethod("noExiste", function(value, element) {
		if (tieneAlMenosSieteDigitos.test(value)) {
			let noExiste;
			$.ajax({
				async: false,
				url : 'alumnos/documentos',
				data : {
					nro_doc: value
				},
				success : function(data){
					noExiste = !data.existe;
				},
				error : function(data){
					alert("Fallo la request ajax para validacion de documento.");
					noExiste = false;
				}
			});
			return noExiste;				
		}
	}, "El documento ya esta registrado.");

	jQuery.validator.addMethod("alMenosSieteDigitos", function(value, element) {
		return tieneAlMenosSieteDigitos.test(value);
	}, "No es un documento valido.");		

	jQuery.validator.addMethod("requerido", function(value, element) {
		return value != "";
	}, "Campo obligatorio");

	jQuery.validator.addMethod("selecciono", function(value, element) {
		sel = $(element).find(':selected').val();
		return sel !== "Seleccionar" && sel != 0;
	}, "Debe seleccionar alguna opcion.");		
	
		//Pregunta si el alta se esta dando desde el abm de participantes o desde el de acciones
		if ($('.container-fluid #creando-participante').length) {

			function backToCreate () {
				$('.container-fluid #creando-participante').remove();
				$('.container-fluid #alta-accion').closest('.row').show();
				$('.container-fluid #alta').remove();
			}
			
			function transitionAfterSubmit(data) {
				$('.container-fluid #creando-participante').remove();
				$('.container-fluid #alta-accion').closest('.row').show();
				$('.container-fluid #alta').remove();
				agregarParticipante(data.data.nombres, data.data.apellidos, data.data.nro_doc, data.data.id_alumno);
			}

		} else {

			function backToCreate () {
				$('#alta').html("");
				$('#abm').show();
				$('#filtros .box').show();
			}
			
			function transitionAfterSubmit(data) {
				location.reload();
			}
			
		}	
		
		$("#alta").on("click","#volver",backToCreate);

		function agregarParticipante(nombres, apellidos, documentos, id) {
			participante = '<tr>'+
			'<td>'+nombres+'</td>'+
			'<td>'+apellidos+'</td>'+
			'<td>'+documentos+'</td>'+
			'<td>'+
			'<div class="btn btn-xs btn-info "><a href="{{url('/alumnos')}}/'+id+'"><i class="fa fa-search" data-id="'+id+'"></i></a></div>'+
			'<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>'+
			'</td>'+
			'</tr>';
			existe = false;

			$.each($('#alumnos-del-curso tbody tr .fa-search'),function(k,v){
				if($(v).data('id') == id){
					existe = true;
				}
			});

			if(!existe){
				$('#alumnos-del-curso tbody').append(participante);     
				$('#alumnos-del-curso').closest('div').show();
				refreshCounter();
			}
		}

		function refreshCounter() {
			let count = $('#alumnos-del-curso tbody').children().length;
			$('#contador-participantes').html(count);
		}
		
		var validator = $('#alta #form-alta').validate({			
			rules : {
				nombres : {required: true},
				apellidos : {required: true},
				localidad : {required: true},
				establecimiento : {required: true},
				efector : {required: true},
				nombre_organismo : {required: true},
				nro_doc : {
					requerido: true,
					alMenosSieteDigitos: true,
					noExiste: true
				},
				tel : {number: true},
				cel : {number: true},
				id_genero: { 
					required: true,
					selecciono : true
				},
				id_funcion: {selecciono : true},
				tipo_organismo: {selecciono : true},
				id_trabajo: { 
					required: true,
					selecciono : true
				},
			},
			messages:{
				nombres : "Campo obligatorio",
				apellidos : "Campo obligatorio",
				localidad : "Campo obligatorio",
				establecimiento : "Campo obligatorio",
				efector : "Campo obligatorio",
				nombre_organismo : "Campo obligatorio",
				tel : "Tiene que ser un numero",
				cel : "Tiene que ser un numero"
			},
			highlight: function(element)
			{
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element)
			{
				$(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
			},
			submitHandler : function(form){
				$.ajax({
					url: "{{url('alumnos')}}",
					type: 'POST',						
					data: getInput(),
					complete: function(xhr, textStatus) {
						console.log('ajax complete');
					},
					success: function(data, textStatus, xhr) {						
						transitionAfterSubmit(data);			
					},
					error: function(xhr, textStatus, errorThrown) {
						alert(xhr.responseText);
					}
				});
			}	
		});
		
	});
</script> 

