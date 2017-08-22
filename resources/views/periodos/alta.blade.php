<div class="box box-success ">
	<div class="box-header">Nuevo periodo</div>
	<div class="box-body">
		<form id="form-alta">
			{{ csrf_field() }}
			<div class="row">					
				<div class="form-group col-xs-12 col-sm-6">
					<label for="nombre" class="control-label col-xs-4 col-sm-2">Nombre:</label>
					<div class="col-xs-8 col-sm-8">
						<input type="text" class="form-control" id="nombre" name="nombre">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label class="col-xs-4 col-sm-2">Desde:</label>
					<div class="input-group date col-xs-8 col-sm-8">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="desde" id="desde" class="form-control pull-right">
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label class="col-xs-4 col-sm-2">Hasta:</label>
					<div class="input-group date col-xs-8 col-sm-8">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="hasta" id="hasta" class="form-control pull-right">
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
				<button class="btn btn-success pull-right" id="crear" title="Alta" type="submit"><i class="fa fa-plus" aria-hidden="true"></i>Alta</button>
			</div>
		</form>
	</div>
</div> 

<script type="text/javascript">
$(document).ready(function () {

	$('#desde').datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
      autoclose: true,
	});

	$('#hasta').datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
      autoclose: true,
	});

	$('#alta form').validate({
		rules : {
			nombre : "required",
			desde : "required",
			hasta : "required"
		},
		messages:{
			nombre : "Campo obligatorio",
			desde : "Especifique fecha",
			hasta : "Especifique fecha"
		},
		highlight: function(element)
		{
			console.log(element)
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function(element)
		{
			console.log(element)
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
		},
		submitHandler : function(form){

			$.ajax({
				method : 'post',
				url : 'periodos',
				data : $('form').serialize(),
				success : function(data){
					location.reload();	
				},
				error : function(data){
					console.log('error');
				}
			});

		}
	});
	
});	
</script>