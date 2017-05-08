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
						<label class="control-label col-xs-4" for="tipo_doc">Tipo de Documento:</label>
						<div class="col-xs-8">
							<select class="form-control" id="tipo_doc" title="Documento nacional de identidad">
								@foreach ($documentos as $documento)
								
								<option data-id="{{$documento->id}}" title="{{$documento->titulo}}">{{$documento->nombre}}</option>				 
								
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
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button type="submit" class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus" aria-hidden="true"></i>Alta</button>
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

		$('#alta').on("click","#volver",function () {
			console.log("Vuelve sin crear el profesor");
			$("#alta").hide();
			$("#filtros").show();
			$("#abm").show();
		});

		$('#alta').on('click','#crear',function() {
			
			var data = $('form').serialize();
			data += '&id_tipo_doc='+$('#alta #tipo_doc :selected').data('id');

			$.ajax({
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
			})
		});


		$("#alta").find("#form-alta").validate({
			onfocusout: false,
			onkeyup: false,
			onclick: false,
			onsubmit: true,
			rules : {
				nombres : {
					required : true
				},
				apellidos : {
					required : true
				},
				tipo_doc : {
					required : true
				},
				nro_doc : {
					required : true
				},
				nacionalidad : {
					required : true
				}
			} ,
			messages : {
				nombres : {
					required : 'Este campo es obligatorio'
				},
				apellidos : {
					required : 'Este campo es obligatorio'
				},
				tipo_doc : {
					required : 'Este campo es obligatorio'
				},
				nro_doc : {
					required : 'Este campo es obligatorio'
				},
				nacionalidad : {
					required : 'Este campo es obligatorio'
				}
			} ,
			highlight: function(element) {
				$(element).closest('.control-group').addClass('has-warning');
			},
			success: function(element) {
				element.text('').addClass('valid')
				.closest('.control-group').removeClass('has-warning').addClass('success');
			},
			submitHandler : function (form) {
				console.log ("Formulario OK");

				console.log('Evento de click en crear');
				console.log($("#form_agregar_memoria").serialize());
				var dataUrl = $("#form_agregar_memoria").serialize();
				console.log(dataUrl);            
			} ,
			invalidHandler : function (event , validator) {
				console.log(validator);
			}
		});
	});
</script>
