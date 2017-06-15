@extends('layouts.adminlte')
@section('content')
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
				<form action="" method="POST" role="form">		
					<div class="form-group">
						<label for="file">Subida</label>
						<input type="file" class="form-control" id="file" placeholder="Archivo">
					</div>					
					<button type="submit" class="btn btn-primary">Enviar</button>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">	
			<iframe src="https://docs.google.com/forms/d/1gyWVvarzF0iKDqUmEclUy2ihJHjveD1bKI5f-I9bYJA/edit?usp=sharing" width="1368" height="768" frameborder="0" marginheight="0" marginwidth="0">Cargando...</iframe>
		</div>
		</div>	
	@endsection