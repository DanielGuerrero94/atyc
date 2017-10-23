<div class="box box-success">
	<div class="box-header with-border">Alta de docente</div>
	<div class="box-body">
		<form id="form-alta">
			{{ csrf_field() }}
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="nombres" class="control-label col-xs-4">Nombres:</label>
					<div class="col-xs-8">
						<input name="nombres" type="text" class="form-control" id="nombres">	
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="apellidos" class="control-label col-xs-4">Apellidos:</label>
					<div class="col-xs-8">
						<input name="apellidos" type="text" class="form-control" id="apellidos">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label col-xs-4" for="id_tipo_documento">Tipo de Documento:</label>
					<div class="col-xs-8">
						<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad" name="id_tipo_documento">
							@foreach ($tipoDocumento as $documento)
							
							<option data-id="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}" value="{{$documento->id_tipo_documento}}">{{$documento->nombre}}</option>					
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label col-xs-4" for="nro_doc">Nro doc:</label>
					<div class="col-xs-8">
						<input name="nro_doc" type="number" class="form-control" id="nro_doc">
					</div>
				</div>

				<div class="form-group col-sm-6" id="nacionalidad" style="display: none">          
					<label class="control-label col-xs-2" for="pais">Pais:</label>
					<div class="typeahead__container col-xs-10">
						<div class="typeahead__field ">         
							<span class="typeahead__query ">
								<input class="pais_typeahead form-control" name="pais" type="search" placeholder="Buscar..." autocomplete="off" id="pais" disabled>
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
							
							<option data-id="{{$tipo->id_tipo_docente}}" value="{{$tipo->id_tipo_docente}}">{{$tipo->nombre}}</option>				 
							
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
						<input name="email" type="email" class="form-control" id="email">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label col-xs-4" for="telefono">Telefono:</label>
					<div class="col-xs-8">
						<input name="tel" type="number" class="form-control" id="tel">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label col-xs-4" for="cel">Cel:</label>
					<div class="col-xs-8">
						<input name="cel" type="number" class="form-control" id="cel">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="box-footer">
		<div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo"></i> Volver</div>
		<button type="submit" class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus"></i> Alta</button>
	</div>
</div> 

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
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('#alta').find('#nacionalidad');
			if ($(this).val() == 'DEX' || $(this).val() == 'PAS' ) {
				nacionalidad.show();
				$('#alta #pais').attr('disabled',false);
			}
			else {
				nacionalidad.hide();
				$('#alta #pais').attr('disabled',true);
			}			
		});

		//Pregunta si el alta se esta dando desde el abm de participantes o desde el de acciones
		if ($('.container-fluid #creando-docente').length) {

			function backToCreate () {
				$('.container-fluid #creando-docente').remove();
				$('.container-fluid #alta-accion').closest('.row').show();
				$('.container-fluid #alta').remove();
			}
			
			function transitionAfterSubmit(data) {
				$('.container-fluid #creando-docente').remove();
				$('.container-fluid #alta-accion').closest('.row').show();
				$('.container-fluid #alta').remove();
				console.log("Se intenta agregar al docente a la accion.");
				agregarDocente(data.nombres, data.apellidos, data.nro_doc, data.id_profesor);
			}

		} else {

			function backToCreate () {
				console.log("Vuelve sin crear al docente");
				$("#alta").hide();
				$("#filtros").show();
				$("#abm").show();
			}
			
			function transitionAfterSubmit(data) {
				location.reload();
			}
			
		}

		/*Validaciones*/
		var tieneAlMenosSieteDigitos = new RegExp(/^\d{7,9}$/);

		jQuery.validator.addMethod("noExiste", function(value, element) {
			console.log(value);
			console.log(tieneAlMenosSieteDigitos.test(value));
			if (tieneAlMenosSieteDigitos.test(value)) {
				let noExiste;
				$.ajax({
					async: false,
					url : 'profesores/documentos',
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
		}, "El documento tiene que tener al menos siete digitos.");		

		jQuery.validator.addMethod("requerido", function(value, element) {
			return value != "";
		}, "Campo obligatorio");	

		$('#alta').on("click","#volver",backToCreate);

		function agregarDocente(nombres, apellidos, documentos, id) {
			docente = '<tr>'+
			'<td>'+nombres+'</td>'+
			'<td>'+apellidos+'</td>'+
			'<td>'+documentos+'</td>'+
			'<td>'+
			'<div class="btn btn-xs btn-info "><a href="{{url('/profesores')}}/'+id+'"><i class="fa fa-search" data-id="'+id+'"></i></a></div>'+
			'<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>'+
			'</td>'+
			'</tr>';
			existe = false;

			$.each($('#profesores-del-curso tbody tr .fa-search'),function(k,v){
				if($(v).data('id') == id){
					existe = true;
				}
			});

			if(!existe){
				console.log("No esta en la tabla entonces se agrega.");
				$('#profesores-del-curso tbody').append(docente);     
				$('#profesores-del-curso').closest('div').show();
				refreshCounter();
			}
		}

		function refreshCounter() {
			let count = $('#profesores-del-curso tbody').children().length;
			$('#contador-docentes').html(count);
		}

		function getInput() {					
			return $('#alta #form-alta').serializeArray().filter(function(v){return v.value != ""});
		}

		var validator = $('#alta #form-alta').validate({
			debug: true,				
			rules : {
				nombres : {required: true},
				apellidos : {required: true},
				nro_doc : {
					requerido: true,
					alMenosSieteDigitos: true,
					noExiste: true
				},
				tel : {number: true},
				cel : {number: true},
			},
			messages:{
				nombres : "Campo obligatorio",
				apellidos : "Campo obligatorio",
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
					url: 'profesores',
					type: 'POST',						
					data: getInput(),
					complete: function(xhr, textStatus) {
						console.log('ajax complete');
					},
					success: function(data, textStatus, xhr) {
						console.log("Se creo el docente y devolvio: " + data);
						transitionAfterSubmit(data);
					},
					error: function(xhr, textStatus, errorThrown) {
						alert('No se pudo dar de alta el profesor.');
					}
				});
			}	
		});

		$('#alta').on('click','#crear',function(e) {
			e.preventDefault();		
			if(validator.valid()){
				$('#alta #form-alta').submit();	
			}
		});
		
	});
</script>
