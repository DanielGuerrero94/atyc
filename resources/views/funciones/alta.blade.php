<div class="box box-success">
	<div class="box-header with-border">
		<a href="#" class="btn pull-left" id="back" title="Volver" onclick="window.location = '{{url()->previous()}}'"><i class="fa fa-arrow-left fa-lg"></i></a>
		<h3 class="box-tittle" style="margin-top: 5px;font-size: 2vw;font-size: 3vh"> Nuevo Rol/Destinatario</h3>						
		<div class="box-tools pull-right" style="margin-top: 5px;">
			<a href="#" class="btn btn-box-tool" id="store" title="Crear">
				<i class="fa fa-floppy-o fa-lg text-success"></i>
			</a>				
		</div>
	</div>
	<div class="box-body">
		<form> 
			{{ csrf_field() }}
			<div class="row">
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
					<label for="nombre" class="control-label col-xs-4">Nombre:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" id="nombre" name="nombre">
					</div>
				</div>
			</div>
		</form>
	</div>
</div> 
<script type="text/javascript">

	$(document).ready(function(){

		var validator = $(".container-fluid #alta form").validate({
			debug: true,
			rules : {
				nombre : {required: true}
			},
			messages:{
				nombre : "Campo obligatorio"
			},
			highlight: function(element)
			{
				$(element).closest(".form-group").removeClass("has-success").addClass("has-error");
			},
			success: function(element)
			{
				$(element).text("").addClass("valid").closest(".form-group").removeClass("has-error").addClass("has-success");
			},
			submitHandler : function(form){
				
				$.ajax({
					method: "POST",
					url: "{{url('/funciones')}}",
					data: $(form).serialize(),
					success: function(data){
						location.reload();
					},
					error: function(error) {
						alert(error.responseText);
					}
				});

			}
		});

		$(".container-fluid").on("click", "#store",function(e){
			$(".container-fluid #alta form").submit();	
		});

	});

</script>