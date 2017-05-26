<div class="col-xs-12">
	<div class="box box-success">
		<div class="box-header">Alta de profesor</div>
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
								@foreach ($documentos as $documento)
								
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
									<input class="pais_typeahead form-control" name="pais" type="search" placeholder="Buscar..." autocomplete="off" id="pais">
								</span>
							</div>
						</div>
					</div>					
				</div>	
				<div class="row">
					<div class="form-group col-sm-6">
						<label class="control-label col-xs-4" for="email">Email:</label>
						<div class="col-xs-8">
							<input name="email" type="text" class="form-control" id="email">
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="control-label col-xs-4" for="telefono">Telefono:</label>
						<div class="col-xs-8">
							<input name="tel" type="text" class="form-control" id="telefono">
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label class="control-label col-xs-4" for="cel">Cel:</label>
						<div class="col-xs-8">
							<input name="cel" type="text" class="form-control" id="cel">
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
			console.log($(this).find(":selected").attr("title"));
			console.log($('#alta').find("#id_tipo_documento").attr("title"));
			$(this).attr("title",$(this).find(":selected").attr("title"));
			var nacionalidad = $('#alta').find('#nacionalidad');
			if ($(this).val() == 'DEX' || $(this).val() == 'PAS' ) {
				nacionalidad.show();
			}
			else {
				nacionalidad.hide();
			}			
		});

		$('#alta').on("click","#volver",function () {
			console.log("Vuelve sin crear el profesor");
			$("#alta").hide();
			$("#filtros").show();
			$("#abm").show();
		});

		$('#alta').on('click','#crear',function() {
			
			var data = $('form').serialize();
			data += '&id_tipo_documento='+$('#alta #id_tipo_documento :selected').data('id');

			/*$.ajax({
				method : 'post',
				url : 'profesores',
				data : data,
				success : function(data){
					console.log("Success.");
					location.reload();	
				},
				error : function(data){
					console.log("Error.");
				}
			})*/
		});

		$('#alta #form-alta').validate({
			debug: true,
			onfocusout: function () {
				var form = $('#alta #form-alta');
				var nro_doc = form.find('#nro_doc');

				if( form.find('#id_tipo_documento').val() == 'DNI' 
					&& nro_doc.val() != ''
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
			}	
		},
		rules : {
			nombres : "required",
			apellidos : "required",
			nro_doc : {
				required: true,
				number: true
			}
		},
		messages:{
			nombres : "Campo obligatorio",
			apellidos : "Campo obligatorio",
			nro_doc : "Campo obligatorio"
		},
		highlight: function(element)
		{
			console.log("highlight");
			console.log(element);
			$(element).closest('.form-control').removeClass('has-success').addClass('has-error');
		},
		success: function(element)
		{
			console.log("validate success");
			$(element).text('').addClass('valid')
			.closest('.control-group').removeClass('has-error').addClass('has-success');
		},
		submitHandler : function(form){

			console.log("validate submitHandler");
			console.log($('form').serialize());
		}	
	});
	});
</script>
