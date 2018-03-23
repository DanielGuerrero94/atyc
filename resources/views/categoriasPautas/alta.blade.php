<div class="box box-success">
	<div class="box-header with-border">Alta de categoria pauta</div>
	<div class="box-body">
		<form id="form-alta">
			{{ csrf_field() }}
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="item" class="control-label col-xs-4">Item:</label>
					<div class="col-xs-8">
						<input name="item" type="number" class="form-control" id="item">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="nombre" class="control-label col-xs-4">Nmbre:</label>
					<div class="col-xs-8">
						<input name="nombre" type="text" class="form-control" id="nombre">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label for="descripcion" class="control-label col-xs-4">Descripcion:</label>
					<div class="col-xs-8">
						<input name="descripcion" type="text" class="form-control" id="descripcion">
					</div>
				</div>           				
			</div>	
			<hr>

		</form>
	</div>
	<div class="box-footer">
		<div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo"></i> Volver</div>
		<button type="submit" class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus"></i> Alta</button>
	</div>
</div> 

<script type="text/javascript">
	$(document).ready(function () {


		function transitionAfterSubmit(data) {
			location.reload();
		}

		jQuery.validator.addMethod("requerido", function(value, element) {
			return value != "";
		}, "Campo obligatorio");	


		function getInput() {					
			return $('#alta #form-alta').serializeArray().filter(function(v){return v.value != ""});
		}

		var validator = $('#alta #form-alta').validate({
			debug: true,				
			rules : {
				item 		: {required: true, number: true },
				nombre      : {required: true},
				descripcion : {required: true}
			},
			messages:{
				descripcion : "Campo obligatorio",
				nombre : "Campo obligatorio",
				item : "Campo obligatorio o Tiene que ser un numero"
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
				console.log($('form').serialize());
				$.ajax({
					url: 'categoriasPautas',
					method : 'post',						
					data : $('form').serialize(),
					success: function(data, textStatus, xhr) {
						console.log("Se creo la categoria de la pauta y devolvio: " + data);
						transitionAfterSubmit(data);
					},
					error: function(xhr, textStatus, errorThrown) {
						alert('No se pudo dar de alta la categoria de la pauta.');
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
