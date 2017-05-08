<div class="col-sm-6 col-sm-offset-3">
	<div class="box box-success ">
		<div class="box-header">Nueva linea estrategica</div>
		<div class="box-body">
			<!-- <form action="{{url('lineasEstrategicas/set')}}" method="post"> -->
			<form> 
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="numero" class="control-label col-xs-4">Número:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="numero" name="numero" required>
						</div>
					</div>
					<div class="form-group col-sm-6">
						<label for="nombre" class="control-label col-xs-4">Nombre:</label>
						<div class="col-xs-8">
							<input type="text" class="form-control" id="nombre" name="nombre" required>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="box-footer">
			<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</button>
			<button class="btn btn-success pull-right" id="crear" title="Alta" type="submit"><i class="fa fa-plus" aria-hidden="true"></i>Alta</button>
		</div>
	</div> 
</div>

<script type="text/javascript">
	$('#form-alta').validate({
		rules : {
			nombre : "required",
			numero : "required",
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