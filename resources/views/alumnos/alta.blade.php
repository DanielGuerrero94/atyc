<div class="col-xs-12">
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
							<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad">
								@foreach ($documentos as $documento)
								
								<option data-id="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}" value="{{$documento->id_tipo_documento}}">{{$documento->nombre}}</option>
								
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-xs-12 col-sm-6">
						<label for="nro_doc" class="control-label col-xs-4">Nro doc:</label>
						<div class="col-xs-8">
							<input name="nro_doc" type="text" class="form-control" id="nro_doc">
						</div>
					</div>
					<div class="form-group col-xs-12 col-sm-6" id="nacionalidad" style="display: none">          
						<label class="control-label col-xs-4" for="pais">Pais:</label>
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
							<select class="form-control" id="provincia">
								@foreach ($provincias as $provincia)
								
								<option data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>									
								@endforeach
							</select>
							@else
							<select class="form-control" id="provincia" name="provincia" disabled>
								<option data-id="{{Auth::user()->id_provincia}}">{{Auth::user()->name}}</option>	
							</select>
							@endif
						</div>
					</div>
					<div class="form-group col-xs-12 col-sm-6">
						<label for="localidad" class="control-label col-xs-4">Localidad:</label>
						<div class="col-xs-8">
							<input id="localidad" type="text" class="form-control" name="localidad">
						</div>
					</div>	
				</div>				
				<hr>
				<div class="row">
					<div class="form-group col-xs-12 col-sm-6">
						<label for="trabaja_en" class="control-label col-xs-4">Trabaja en:</label>
						<div class="col-xs-8">
							<select class="form-control" id="trabaja_en" name="trabaja_en">

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
							<select class="form-control" id="tipo_organismo" name="organismo">

								<option>Seleccionar</option>

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
					<div class="form-group col-xs-12 col-sm-6" style="display: none;">          
						<label for="efectores" class="control-label col-xs-4">Efectores:</label>
						<div class="typeahead__container col-xs-8">
							<div class="typeahead__field ">         
								<span class="typeahead__query ">
									<input class="efectores_typeahead form-control" name="efector" type="search" placeholder="Buscar..." autocomplete="off" id="efectores" disabled>
								</span>
							</div>
						</div>
					</div>
					<button type="button" class="btn btn-default" id="ver_efectores" style="display: none;">Ver todos</button>
				</div>
				<div class="row">
					<div class="form-group col-xs-12 col-sm-6" style="display: none">          
						<label for="establecimiento" class="control-label col-xs-4">Establecimiento:</label>
						<div class="typeahead__container col-xs-8">
							<div class="typeahead__field ">             
								<span class="typeahead__query ">
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
							<select class="form-control" id="funcion" name="funcion">

								<option data-id="1" title="Seleccionar">Seleccionar</option>

								@foreach ($funciones as $funcion)

								<option data-id="{{$funcion->id_funcion}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>	

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
					<div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</div>
					<button class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus" aria-hidden="true"></i>Alta</button>
				</div>
			</form>
		</div>
		
	</div> 
</div>

<script type="text/javascript">

	$(document).ready(function () {

		//Typeahead para campos demasiado grandes como para traer una sola request
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
							search: "@{{query}}"
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

		$.typeahead({
			input: '.pais_typeahead',
			order: "desc",
			source: {
				info: {
					ajax: {
						url: "paises/nombres",
						path: "data.info",
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

		$.typeahead({
			input: '.efectores_typeahead',
			maxItem: 15,
			order: "desc",
			backdrop: {
				"background-color": "#fff"
			},
			dropdownFilter: "Filtro",
			emptyTemplate: 'No hay resultados',
			source: {
				nombre: {
					ajax: {
						url: "efectores/typeahead",
						path: "data.nombres",
						data: {
							search: "@{{query}}"
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				cuie: {
					ajax: {
						url: "efectores/typeahead",
						path: "data.cuies",
						data: {
							search: "@{{query}}"
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

		$.typeahead({
			input: '.nombre_organismo_typeahead',
			order: "desc",
			source: {
				info: {
					ajax: {
						url: "alumnos/nombre_organismo",
						path: "data.info",
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

		/*Funciones para que aparezacan o desaparezcan campos en el
		formulario*/

		$('#alta').on("click","#trabaja_en",function () {
			console.log('asd');
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var tipo_organismo = $('#alta').find('#tipo_organismo').closest('.form-group');
			var tipo_convenio = $('#alta').find('#tipo_convenio').closest('.form-group');
			var nombre_organismo = $('#alta').find('#nombre_organismo').closest('.form-group');
			var funcion = $('#alta').find('#funcion').closest('.form-group');

			//Respeta los valores en la base de datos
			if ($(this).val() == 3) {
				tipo_organismo.show();
				nombre_organismo.show();
				$('#nombre_organismo').attr('disabled',false);
				funcion.show();
				tipo_convenio.hide();
				$('#alta').find('#tipo_convenio').prop('checked',false);
				establecimiento.hide();
				$('#establecimiento').attr('disabled',true);
				efectores.hide();
				$('#efectores').attr('disabled',true);
			}
			else if($(this).val() == 2){
				tipo_convenio.show();				
				establecimiento.show();
				$('#establecimiento').attr('disabled',false);
				tipo_organismo.hide();
				nombre_organismo.hide();
				$('#nombre_organismo').attr('disabled',true);
				funcion.show();
			}
			else {
				tipo_organismo.hide();
				tipo_convenio.hide();
				$('#alta').find('#tipo_convenio').prop('checked',false);
				nombre_organismo.hide();
				funcion.hide();
				establecimiento.hide();
				$('#establecimiento').attr('disabled',true);
				efectores.hide();
				$('#efectores').attr('disabled',true);
			}			
		});

		$('#alta').on('change','.checkbox',function () {			

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

		$('#alta').on("click","#id_tipo_documento",function () {
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('#alta').find('#nacionalidad');
			if ($(this).val() == 5 || $(this).val() == 6 ) {
				nacionalidad.show();
				$('#pais').attr('disabled',false);
			}
			else {
				nacionalidad.hide();
				$('#pais').attr('disabled',true);
			}			
		});

		/*funciones abm*/

		function getCreateJson() {
			var nombres = $('#nombres')	.val();
			var apellidos = $('#apellidos').val();
			var id_tipo_documento = $('#id_tipo_documento option:selected').data('id');
			var id_genero = $('#id_genero option:selected').val();
			var nro_doc = $('#nro_doc').val();
			var email = $('#email').val();
			var cel = $('#cel').val();
			var tel = $('#tel').val();
			var localidad = $('#localidad').val();
			var id_provincia = $('#provincia option:selected').data('id');

			var form = $('#alta #form-alta');
			var provincia = form.find('#provincia :selected').data('id');
			var trabaja_en = form.find('#trabaja_en :selected').data('id');
			var funcion = form.find('#funcion :selected').data('id');
			var token = form.find('input').val();

			var serializado = $('#alta :input').not(':hidden').serialize();

			serializado += '&id_tipo_doc='+id_tipo_documento;
			serializado += '&id_provincia='+provincia;
			serializado += '&id_trabaja_en='+trabaja_en;
			serializado += '&funcion='+funcion;
			serializado += '&_token='+token;
			console.log(serializado);

			return data = {
				nombres: nombres,
				apellidos: apellidos,
				id_tipo_documento: id_tipo_documento,
				id_genero: id_genero,
				nro_doc: nro_doc,
				email: email,
				cel: cel,
				tel: tel,
				localidad: localidad,
				id_provincia: id_provincia
			};
		};

		function getSelected() {
			var id_tipo_documento = $('#form-alta #id_tipo_documento :selected').data('id');
			var id_provincia = $('#form-alta #provincia :selected').data('id');
			var id_trabajo = $('#form-alta #trabaja_en :selected').data('id');
			var id_funcion = $('#form-alta #funcion :selected').data('id');

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
			return $.merge($('#form-alta').serializeArray(),getSelected());
		}						

		jQuery.validator.addMethod("selecciono", function(value, element) {
			return $(element).find(':selected').val() !== "Seleccionar";
		}, "Debe seleccionar alguna opcion.");		

		var esNumero = new RegExp(/^[1-9]\d*$/i);

		var validator = $('#alta #form-alta').validate({
			debug: true,
			onfocusout: function () {
				var form = $('#alta #form-alta');
				var nro_doc = form.find('#nro_doc');

				if( form.find('#id_tipo_documento').val() == 'DNI' 
					&& nro_doc.val() != ''
					&& esNumero.test(nro_doc.val()) 					
					&& !nro_doc.closest('.form-group').hasClass('has-success')){

					$.ajax({
						method : 'get',
						url : 'alumnos/documentos/'+nro_doc.val(),
						success : function(data){

							if(data == "true"){
								console.log("El documento ya esta registrado.");
								nro_doc.closest('.form-group').addClass('has-error').removeClass('has-success');
								if(!nro_doc.parent().find('span').length){
									nro_doc.parent().append("<span class=\"help-block\">El numero de documento ya esta registrado</span>");	
								}						
							}
							else{
								nro_doc.parent().find('span').remove();
								nro_doc.closest('.form-group').removeClass('has-error').addClass('has-success');	
							}
						},
						error : function(data){
							console.log("Fallo la request ajax para validacion de documento.");
						}
					});

			}else if(!esNumero.test(nro_doc.val())){
				nro_doc.closest('.form-group').addClass('has-error').removeClass('has-success');
				if(!nro_doc.parent().find('span').length){
					nro_doc.parent().append("<span class=\"help-block\">Tiene que ingresar un numero de documento</span>");	
				}
			}	
		},
		rules : {
			nombres : "required",
			apellidos : "required",
			localidad : "required",
			establecimiento : "required",
			efector : "required",
			nombre_organismo : "required",
			nro_doc : {
				required: true,
				number: true
			},
			tel : {
				number: true
			},
			cel : {
				number: true
			},
			id_genero: { selecciono : true},
			funcion: { selecciono : true},
			organismo: { selecciono : true},
			tipo_organismo: { selecciono : true},
			trabaja_en: { selecciono : true},
		},
		messages:{
			nombres : "Campo obligatorio",
			apellidos : "Campo obligatorio",
			localidad : "Campo obligatorio",
			establecimiento : "Campo obligatorio",
			efector : "Campo obligatorio",
			nombre_organismo : "Campo obligatorio",
			nro_doc : "Tiene que ser un numero",
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
			console.log("submitHandler");
			$.ajax({
				url: 'alumnos',
				type: 'POST',						
				data: getInput(),
				complete: function(xhr, textStatus) {
					console.log('ajax complete');
				},
				success: function(data, textStatus, xhr) {
					console.log('Se creo');
					console.log(data);
					location.reload();
				},
				error: function(xhr, textStatus, errorThrown) {
					console.log('Fallo');
				}
			});
		}	
	});

		
		/*$('#alta').on("click","#crear",function () {
			$.ajax({
				method : 'post',
				url : 'alumnos',
				data : serializado,
				success : function(data){
					console.log(jQuery.parseJSON(data));
					console.log(jQuery.parseJSON(data).nro_doc);
					location.reload();
				},
				error : function(data){
					alert("El alumno no se pudo dar de alta.");
					console.log("Ajax Error.");
					console.log(data);
				}
			});
		});*/
	});
</script> 

