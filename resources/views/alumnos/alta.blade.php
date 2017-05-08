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
							<select class="form-control" id="tipo_doc" title="Documento nacional de identidad">
								@foreach ($documentos as $documento)
								
								<option data-id="{{$documento->id}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>
								
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
							<select class="form-control" id="provincia">
								@foreach ($provincias as $provincia)
								
								<option data-id="{{$provincia->id}}" title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>									
								@endforeach
							</select>
						</div>
					</div>			
				</div>	
				<hr>
				<div class="row">
					<div class="form-group">
						<label for="trabaja_en" class="control-label col-xs-2">Trabaja en:</label>
						<div class="col-xs-6">
							<select class="form-control" id="trabaja_en">

								<option data-id="null">Seleccionar</option>

								@foreach ($trabajos as $trabajo)
								
								<option data-id="{{$trabajo->id}}" title="{{$trabajo->nombre}}">{{$trabajo->nombre}}</option>				 					
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
						<button type="button" class="btn btn-info filter" title="Filtro avanzado"><i class="fa fa-sliders" aria-hidden="true"></i></button>
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
							<select class="form-control" id="funcion">

								<option data-id="1" title="Seleccionar">Seleccionar</option>

								@foreach ($funciones as $funcion)

								<option data-id="{{$funcion->id}}" title="{{$funcion->nombre}}">{{$funcion->nombre}}</option>	

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
					<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
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
				info: {
					ajax: {
						type: "get",
						url: "efectores/cuies",
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
			input: '.nombre_organismo_typeahead',
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

		/*Funciones para que aparezacan o desaparezcan campos en el
		formulario*/

		$('#alta').on("click","#trabaja_en",function () {
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var tipo_organismo = $('#alta').find('#tipo_organismo').closest('.form-group');
			var tipo_convenio = $('#alta').find('#tipo_convenio').closest('.form-group');
			var nombre_organismo = $('#alta').find('#nombre_organismo').closest('.form-group');
			var funcion = $('#alta').find('#funcion').closest('.form-group');
			var establecimiento = $('#alta').find('#establecimiento').closest('.form-group');

			if ($(this).val() == 'ORGANISMO GUBERNAMENTAL') {
				tipo_organismo.show();
				nombre_organismo.show();
				funcion.show();
				tipo_convenio.hide();
				establecimiento.hide();
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
				nombre_organismo.hide();
				funcion.hide();
				establecimiento.hide();
			}			
		});

		var establecimiento = $('#alta').find('#establecimiento').parent().parent().parent().parent();
		var efectores = $('#alta').find('#efectores').parent().parent().parent().parent();

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
			console.log($(this).find(":selected").attr("title"));
			console.log($('#alta').find("#tipo_doc").attr("title"));
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
			/*var serializado = form.serialize();*/

			var serializado = $('#alta :input').not(':hidden').serialize();

			/*console.log(filtrado);*/
			console.log(serializado);
			console.log(form);
			console.log(tipo_doc);
			console.log(provincia);
			console.log(trabaja_en);
			console.log(funcion);

			serializado += '&tipo_doc='+tipo_doc;
			serializado += '&provincia='+provincia;
			serializado += '&trabaja_en='+trabaja_en;
			serializado += '&funcion='+funcion;
			serializado += '&_token='+token;
			console.log(serializado);

			$.ajax({
				method : 'post',
				url : 'alumnos',
				data : serializado,
				success : function(data){
					console.log("Success.");
					location.reload();	
				},
				error : function(data){
					console.log("Error.");
				}
			});

		});
	});	

$('#alta form').validate({
	onfocusout: function () {
		if($('#alta form #tipo_doc').val() == 'DNI' && $('#alta form #nro_doc').val() != ''){

			$.ajax({
				method : 'get',
				url : 'alumnos/documentos/'+$('#alta form #nro_doc').val(),
				success : function(data){
					
					console.log("Reviso si existe");
					console.log(data);
					if(data === "true"){
						$('#alta form #nro_doc').removeClass('error').addClass('valid');
					}
					else{
						console.log("El documento ya esta registrado.");
						$('#alta form #nro_doc').removeClass('valid').addClass('error');
					}
				},
				error : function(data){
					console.log("No se puede verificar el documento.");
				}
			});

		}	
	},
	rules : {
		nombres : "required",
		apellidos : "required",
		nro_doc : {
			required: true,
			number: true
		},
		localidad : "required",
		establecimiento : "required",
		efectores : "required",
		nombre_organismo : "required",
		funcion: {
			depends: function (element) {
				return $('#alta form #funcion :selected').val() !== "Seleccionar";
			}
		} 
	},
	messages:{
		nombres : "Campo obligatorio",
		apellidos : "Campo obligatorio",
		nro_doc : "Campo obligatorio",
		localidad : "Campo obligatorio",
		establecimiento : "Campo obligatorio",
		efectores : "Campo obligatorio",
		nombre_organismo : "Campo obligatorio",
		funcion : {
			depends: "Debe seleccionar una opcion"
		}
	},
	highlight: function(element)
	{
		console.log(element);
		$(element).closest('.form-control').removeClass('success').addClass('error');
	},
	success: function(element)
	{
		$(element).text('').addClass('valid')
		.closest('.control-group').removeClass('error').addClass('success');
	},
	submitHandler : function(form){

		console.log($('form').serialize());

		$.ajax({
			method : 'post',
			url : 'areasTematicas/set',
			data : $('form').serialize(),
			success : function(data){
				console.log("Success.");
				location.reload();	
			},
			error : function(data){
				console.log("Error.");
			}
		});
	}
});


</script> 
