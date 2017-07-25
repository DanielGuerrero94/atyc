<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box box-success">
		<div class="box-header">Alta de docente</div>
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
							<select class="form-control" id="id_tipo_documento" title="Documento nacional de identidad">
								@foreach ($tipoDocumento as $documento)
								
								<option data-id="{{$documento->id_tipo_documento}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>				 
								
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="control-label col-xs-4" for="nro_doc">Nro doc:</label>
						<div class="col-xs-8">
							<input name="nro_doc" type="text" class="form-control" id="nro_doc">
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
							<select class="form-control" id="id_tipo_docente">
								@foreach ($tipoDocente as $tipo)
								
								<option data-id="{{$tipo->id_tipo_docente}}">{{$tipo->nombre}}</option>				 
								
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
			<div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo"></i>Volver</div>
			<button type="submit" class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus"></i>Alta</button>
		</div>
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

		$('#alta').on("click","#volver",function () {
			console.log("Vuelve sin crear el profesor");
			$("#alta").hide();
			$("#filtros").show();
			$("#abm").show();
		});

		function getSelected() {
			var id_tipo_documento = $('#form-alta #id_tipo_documento :selected').data('id');
			var id_tipo_docente = $('#form-alta #id_tipo_docente :selected').data('id');
			return [{
				name: 'id_tipo_documento',
				value: id_tipo_documento
			},
			{
				name: 'id_tipo_docente',
				value: id_tipo_docente
			}];
		}

		function getInput() {					
			return $.merge($('#form-alta').serializeArray(),getSelected());
		}

		var validator = $('#alta #form-alta').validate({
			debug: true,				
			rules : {
				nombres : {
					required: true
				},
				apellidos : {
					required: true
				},
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
			},
			messages:{
				nombres : "Campo obligatorio",
				apellidos : "Campo obligatorio",
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
			onfocusout: function () {
				var form = $('#alta #form-alta');
				var nro_doc = form.find('#nro_doc');

				if( form.find('#id_tipo_documento').val() == 'DNI' 
					&& nro_doc.val() != ''
					&& !nro_doc.closest('.form-group').hasClass('has-success')){

					$.ajax({
						method : 'get',
						url : 'profesores/documentos/'+nro_doc.val(),
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
				}	
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
						console.log('Se creo');
						location.reload();
					},
					error: function(xhr, textStatus, errorThrown) {
						alert('No se pudo dar de alta el profesor.');
					}
				});
			}	
		});

		$('#alta').on('click','#crear',function() {			
			if(validator.valid()){
				$('#alta #form-alta').submit();	
			}
		});
		
	});
</script>
