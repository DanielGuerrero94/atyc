<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success ">
		<div class="box-header">Nuevo Responsable</div>
		<div class="box-body">
			<form id="form-alta">
				{{ csrf_field() }}
				<div class="row">					
					<div class="form-group col-sm-12">
						<label for="nombre" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="nombre" name="nombre">
						</div>
					</div>
				</div>

				<div class="box-footer">
					<a class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</a>
					<button class="btn btn-success pull-right" id="crear" title="Alta"><i class="fa fa-plus" aria-hidden="true"></i>Alta</button>
				</div>
			</form>
		</div>
	</div> 
</div>

<script type="text/javascript">
	$('#alta form').validate({
		rules : {
			nombre : "required"
		},
		messages:{
			nombre : "Campo obligatorio"
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
				url : 'responsables',
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