@extends('layouts.adminlte')
@section('content')
<div class="container">
	<div class="col-xs-12">
		<div class="box box-success">
			<div class="box-header">Rol/Destinatario
				<div class="box-title">
					<div class="btn-group pull-right" role="group" aria-label="...">
						<div type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></div>
						<div type="button" id="editar" class="btn btn-box-tool btn-default" title="Editar"><i class="fa fa-pencil-square-o text-info" aria-hidden="true"> Editar</i></div>
					</div>
				</div>
			</div>
			<div class="box-body">				
				<form id="form-editar">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
							<label for="nombre" class="control-label col-xs-4">Nombre:</label>
							<div class="col-xs-8">
								<input type="text" class="form-control" id="nombre" name="nombre" required disabled="true">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
				<a href="{{url()->previous()}}">
					<button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i> Volver</button>
				</a>
			</div>
		</div> 
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function () {

		$('.container').on('click', '#editar', function () {
			console.log('Quiere editar');

			$('#form-editar :input').attr('disabled', false);			

			jQuery('<div/>', {
				class: 'btn btn-box-tool btn-default',
				id: 'editar',
				title: 'Editar',
				type: 'button'
			}).appendTo('.container-fluid');

			jQuery('<i/>', {
				class: 'fa fa-pencil-square-o text-info',
				text: ' Editar'
			}).appendTo('#editar');

		});

		$(".container").on("click","#volver",function(){
			window.location = "{{url('/funciones')}}";
		});

		$(".container").on("click","#guardar",function () {
			var data = $('#form-editar').serialize();

			$.ajax({
				url: "{{url('/funciones/edit')}}",
				method: 'put',
				data: data,
				success: function(data){
					window.location = "{{url('/funciones')}}";
				},
				error: function (data) {
					console.log('Error.');
					console.log(data);
				}
			});

		});

	});
</script>
@endsection