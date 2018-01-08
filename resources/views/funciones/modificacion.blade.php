@extends('layouts.adminlte')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			<div class="box box-success">
				<div class="box-header with-border">
					<a href="#" class="btn pull-left" id="back" title="Volver" onclick="window.location = '{{url()->previous()}}'"><i class="fa fa-arrow-left"></i></a>
					<div class="box-tittle">							
						<span style="font-size: 2vw;font-size: 3vh;">Rol/Destinatario</span>						
					</div>					
					<div class="box-tools pull-right" style="margin-top: 5px;">
					</div>
				</div>
				<div class="box-body">				
					<form id="form-edit" data-id="{{$funcion->id_funcion}}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row">
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
								<label for="nombre" class="control-label col-xs-4 col-sm-3 col-md-3 col-lg-2">Nombre:</label>
								<div class="col-xs-8 col-sm-9 col-md-9 col-lg-10">
									<input type="text" class="form-control" id="nombre" name="nombre" required disabled="true" value="{{$funcion->nombre}}">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div> 
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">

	editButton = jQuery('<div/>', {
		class: 'btn btn-box-tool',
		id: 'edit',
		title: 'Editar',
		type: 'button'
	});

	editIcon = jQuery('<i/>', {
		class: 'fa fa-pencil-square-o fa-lg text-info',
	}); 

	saveButton = jQuery('<div/>', {
		class: 'btn btn-box-tool',
		id: 'save',
		title: 'Guardar',
		type: 'button'
	});

	saveIcon = jQuery('<i/>', {
		class: 'fa fa-floppy-o fa-lg text-success',
	}); 		

	function changeToSave() {
		$('.container-fluid .box-tools #edit').remove();
		saveButton.appendTo('.container-fluid .box-tools');
		saveIcon.appendTo('#save');
	}

	function changeToEdit() {
		$('.container-fluid .box-tools #save').remove();
		editButton.appendTo('.container-fluid .box-tools');
		editIcon.appendTo('#edit');
	}

	$(document).ready(function () {		

		changeToEdit();

		$('.container-fluid').on('click', '#edit', function () {
			$('#form-edit :input').each(function(){$(this).attr('disabled', false)});
			changeToSave();
		});

		$(".container-fluid").on("click","#save",function () {
			$(".container-fluid form").submit();
		});

		$(".container-fluid form").validate({
			rules : {
				nombre : "required",
			},
			messages:{
				nombre : "Campo obligatorio",
			},
			highlight: function(element)
			{
				$(element).closest('.form-control').removeClass('has-success').addClass('has-error');
			},
			success: function(element)
			{
				$(element).text('').addClass('valid')
				.closest('.control-group').removeClass('has-error').addClass('has-success');
			},
			submitHandler : function(form){
				let formData = $(form);
				let id = formData.data('id');
				let data = formData.serialize();

				$.ajax({
					url: "{{url('/funciones')}}" + "/" + id,
					method: "PUT",
					data: data,
					success: function(data){
						window.location = "{{url()->previous()}}";
					},
					error: function (data) {
						alert(data.responseText);
					}
				});

			}
		});

	});

</script>
@endsection