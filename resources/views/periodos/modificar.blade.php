@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div id="modificacion" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			<div class="box box-success ">
				<div class="box-header">Periodo</div>
				<div class="box-body">
					<form> 
						{{ csrf_field() }}
						{{ method_field('PUT') }}	
						<div class="row">
							<div class="form-group col-xs-12 col-sm-6">
								<label for="nombre" class="control-label col-xs-4 col-sm-2">Nombre:</label>
								<div class="col-xs-8 col-sm-8">
									<input type="text" class="form-control" id="nombre" name="nombre" value="{{$periodo->nombre}}" required>
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
							<a href="{{url()->previous()}}"><div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</div></a>
							<button class="btn btn-primary pull-right" id="modificar" title="Modificar" type="submit" data-id="{{$periodo->id_periodo}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar</button>
						</div>
					</form>
				</div>				
			</div> 
		</div>
	</div>
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
		
		$('#desde').datepicker('setDate','{{$periodo->desde}}');	
		$('#hasta').datepicker('setDate','{{$periodo->hasta}}');	
		
		$('.container-fluid form').validate({
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
				$(element).closest('.form-control').removeClass('has-success').addClass('has-error');
			},
			success: function(element)
			{
				$(element).text('').addClass('valid')
				.closest('.control-group').removeClass('has-error').addClass('has-success');
			},
			submitHandler : function(form){
				
				$.ajax({
					method : 'put',
					url : "{{url('periodos')}}" + '/' + $('#modificar').data('id'),
					data : $('form').serialize(),
					success : function(data){
						window.location = "{{url('periodos')}}";
					},
					error : function(data){
						alert("Hubo un problema al modificar el periodo.")
					}
				});
				
			}
		});
		
	});	
</script>
@endsection