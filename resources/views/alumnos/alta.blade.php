<div class="col-xs-12">
	<div class="box box-success ">
		<div class="box-header">Alta de alumno</div>
		<div class="box-body">
			<form id="form-alta">
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="nombres" class="control-label col-xs-4">Nombres:</label>
						<div class="col-xs-6">
							<input name="nombres" type="text" class="form-control" id="nombres">
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label for="apellidos" class="control-label col-xs-2">Apellidos:</label>
						<div class="col-xs-6">
							<input name="apellidos" type="text" class="form-control" id="apellidos">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label col-xs-4" for="tipo_doc">Tipo de Documento:</label>
						<div class="col-xs-6">
							<select class="form-control" id="tipo_doc" title="Documento nacional de identidad" name="tipo_doc">
								@foreach ($documentos as $documento)
								
								<option data-id="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>
								
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label for="nro_doc" class="control-label col-xs-2">Nro doc:</label>
						<div class="col-xs-6">
							<input name="nro_doc" type="text" class="form-control" id="nro_doc">
						</div>
					</div>
					<div class="form-group col-sm-6" id="nacionalidad" style="display: none">          
						<label class="control-label col-xs-2" for="pais">Pais:</label>
						<div class="typeahead__container col-xs-10">
							<div class="typeahead__field ">         
								<span class="typeahead__query ">
									<input class="pais_typeahead form-control" name="pais" type="search" placeholder="Buscar..." autocomplete="off" id="pais">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="localidad" class="control-label col-xs-4">Localidad:</label>
						<div class="col-xs-6">
							<input name="localidad" type="text" class="form-control" id="localidad">
						</div>
					</div>					
					<div class="form-group col-sm-6">
						<label for="provincia" class="control-label col-xs-2">Provincia:</label>
						<div class="col-xs-6">
							@if(Auth::user()->id_provincia == 25)
							<select class="form-control" id="provincia" name="provincia">
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
				</div>	
				<hr>
				<div class="row">
					<div class="form-group">
						<label for="trabaja_en" class="control-label col-xs-2">Trabaja en:</label>
						<div class="col-xs-6">
							<select class="form-control" id="trabaja_en" name="trabaja_en">

								<option data-id="0">Seleccionar</option>

								@foreach ($trabajos as $trabajo)
								
								<option data-id="{{$trabajo->id_trabajo}}" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>				 					
								@endforeach
								
							</select>
						</div>
					</div>
				</div>
				<br>
				<div class="row" >
					<div class="form-group" style="display: none;">
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
				<div class="row">
					<div class="form-group" style="display: none">  
						<label for="nombre_organismo" class="control-label col-xs-2">Nombre organismo:</label>					
						<div class="typeahead__container col-xs-6">
							<div class="typeahead__field ">         
								<span class="typeahead__query ">
									<input class="nombre_organismo_typeahead form-control" name="nombre_organismo" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" id="nombre_organismo">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group checkbox" style="display: none;">	
						<label for="tipo_convenio" class="control-label col-xs-2">Tipo convenio:</label>
						<div class="col-xs-6">
							<input name="tipo_convenio" type="checkbox" id="tipo_convenio">Convenio con el programa CUS SUMAR
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
									<input class="efectores_typeahead form-control" name="efectores" type="search" placeholder="Buscar..." autocomplete="off" id="efectores">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group" style="display: none">          
						<label for="establecimiento" class="control-label col-xs-2">Establecimiento:</label>
						<div class="typeahead__container col-xs-6">
							<div class="typeahead__field ">             
								<span class="typeahead__query ">
									<input class="establecimiento_typeahead form-control" name="establecimiento" type="search" placeholder="Buscar o agregar uno nuevo" autocomplete="off" id="establecimiento">
								</span>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="form-group" style="display: none;">
						<label for="funcion" class="control-label col-xs-2">Funcion que desempeña:</label>
						<div class="col-xs-6">
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
					<div class="form-group col-sm-4">
						<label for="email" class="control-label col-xs-2">Email:</label>
						<div class="col-xs-7">
							<input name="email" type="text" class="form-control" id="email">
						</div>
					</div>
					<div class="form-group col-sm-4">
						<label for="tel" class="control-label col-xs-2">Tel:</label>
						<div class="col-xs-7">
							<input name="tel" type="text" class="form-control" id="tel">
						</div>
					</div>
					<div class="form-group col-sm-4">
						<label for="cel" class="control-label col-xs-2">Cel:</label>
						<div class="col-xs-7">
							<input name="cel" type="text" class="form-control" id="cel">
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
			source: {
				info: {
					ajax: {
						url: "alumnos/establecimientos",
						path: "data.info",
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
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				/*siisa: {
					ajax: {
						url: "efectores/typeahead",
						path: "data.siisas",
						success: function(data){
							console.log("ajax success");
							console.log(data);							
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},*/

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


		var establecimiento = $('#alta').find('#establecimiento').closest('.form-group');
		var efectores = $('#alta').find('#efectores').closest('.form-group');

		/*Funciones para que aparezacan o desaparezcan campos en el
		formulario*/

		$('#alta').on("click","#trabaja_en",function () {
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var tipo_organismo = $('#alta').find('#tipo_organismo').closest('.form-group');
			var tipo_convenio = $('#alta').find('#tipo_convenio').closest('.form-group');
			var nombre_organismo = $('#alta').find('#nombre_organismo').closest('.form-group');
			var funcion = $('#alta').find('#funcion').closest('.form-group');

			if ($(this).val() == 'ORGANISMO GUBERNAMENTAL') {
				tipo_organismo.show();
				nombre_organismo.show();
				funcion.show();
				tipo_convenio.hide();
				$('#alta').find('#tipo_convenio').prop('checked',false);
				establecimiento.hide();
				efectores.hide();
			}
			else if($(this).val() == 'ESTABLECIMIENTO DE SALUD'){
				tipo_convenio.show();				
				establecimiento.show();
				tipo_organismo.hide();
				nombre_organismo.hide();
				funcion.show();
			}
			else {
				tipo_organismo.hide();
				tipo_convenio.hide();
				$('#alta').find('#tipo_convenio').prop('checked',false);
				nombre_organismo.hide();
				funcion.hide();
				establecimiento.hide();
				efectores.hide();
			}			
		});

		$('#alta').on('change','.checkbox',function () {			

			if(efectores.is(':hidden')){
				efectores.show();
				establecimiento.hide();
			}
			else{
				efectores.hide();
				establecimiento.show();	
			}

		});					

		$('#alta').on("click","#tipo_doc",function () {
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('#alta').find('#nacionalidad');
			if ($(this).val() == 'DEX' || $(this).val() == 'PAS' ) {
				nacionalidad.show();
			}
			else {
				nacionalidad.hide();
			}			
		});

		/*funciones abm*/

		$('#alta').on("click","#crear",function () {
			
			var form = $('#alta #form-alta');
			var tipo_doc = form.find('#tipo_doc :selected').data('id');
			var provincia = form.find('#provincia :selected').data('id');
			var trabaja_en = form.find('#trabaja_en :selected').data('id');
			var funcion = form.find('#funcion :selected').data('id');
			var token = form.find('input').val();

			var serializado = $('#alta :input').not(':hidden').serialize();

			serializado += '&id_tipo_doc='+tipo_doc;
			serializado += '&id_provincia='+provincia;
			serializado += '&id_trabaja_en='+trabaja_en;
			serializado += '&funcion='+funcion;
			serializado += '&_token='+token;
			console.log(serializado);

			$.ajax({
				method : 'post',
				url : 'alumnos',
				data : serializado,
				success : function(data){
					console.log(jQuery.parseJSON(data));
					console.log(jQuery.parseJSON(data).nro_doc);
					/*location.reload();	*/
				},
				error : function(data){
					alert("El alumno no se pudo dar de alta.");
					console.log("Ajax Error.");
					console.log(data);
				}
			});

		});		

		jQuery.validator.addMethod("selecciono", function(value, element) {
			return $(element).find(':selected').val() !== "Seleccionar";
		}, "Debe seleccionar alguna opcion");

		var esNumero = new RegExp(/^[1-9]\d*$/i);

		$('#alta form').validate({
			debug: true,
			onfocusout: function () {
				var form = $('#alta form');
				var nro_doc = form.find('#nro_doc');

				if( form.find('#tipo_doc').val() == 'DNI' 
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
			efectores : "required",
			nombre_organismo : "required",
			funcion: { selecciono : true},
			tipo_organismo: { selecciono : true}
		},
		messages:{
			nombres : "Campo obligatorio",
			apellidos : "Campo obligatorio",
			localidad : "Campo obligatorio",
			establecimiento : "Campo obligatorio",
			efectores : "Campo obligatorio",
			nombre_organismo : "Campo obligatorio"
		},
		highlight: function(element)
		{
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function(element)
		{
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
		},
		submitHandler : function(form){
			console.log("submitHandler");
		}	
	});
	});
</script> 

