@extends('layouts.adminlte')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">	
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4 style="color: rgb(0,0,0);"><i class="icon fa fa-warning"></i> Aclaración</h4>
				<span style="color: rgb(0,0,0);">El profesor no deberia ver las respuestas individuales pero si el resultado general.
				De aca se puede exportar el excel y migrar a la base de datos para poder hacer informes mas generales.</span>
			</div>
		</div>
	</div>
	<div class="row text-center">
		<div class=" box box-success col-xs-10 col-sm-6 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
			<div class="box-body">		
				<form id="upload" name="upload">
					{{ csrf_field() }}
					<input type="numeric" name="id_curso" value="8234">
					<label style="cursor: pointer;color: #2F2D2D;">
						<input type="file" style="display: none;" name="encuesta">
						<i class="fa fa-upload"></i> Subir
					</label>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">	
			<iframe src="https://docs.google.com/forms/d/1gyWVvarzF0iKDqUmEclUy2ihJHjveD1bKI5f-I9bYJA/edit?usp=sharing" width="1368" height="768" frameborder="0" marginheight="0" marginwidth="0">Cargando...</iframe>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$(".container-fluid").on('change', '#upload input', function(event) {
			data = new FormData($('#upload')[0]);
			$.ajax({
				url: '{{url('encuestas/subida')}}',
				type: 'POST',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log('successsssss');
					console.log(data);
				}
			})
			.done(function() {
				console.log("success");
				location.reload();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});

	});
</script>	
@endsection
