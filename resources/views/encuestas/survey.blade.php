@extends('layouts.adminlte')
@section('content')
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">	
		<div class="alert alert-warning alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4 style="color: rgb(0,0,0);"><i class="icon fa fa-warning"></i> Aclaración</h4>
			<span style="color: rgb(0,0,0);">El profesor no deberia ver las respuestas individuales pero si el resultado general.
			De aca se puede exportar el excel y migrar a la base de datos para poder hacer informes mas generales.</span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">	
		<iframe src="https://docs.google.com/forms/d/1gyWVvarzF0iKDqUmEclUy2ihJHjveD1bKI5f-I9bYJA/edit?usp=sharing" width="1368" height="768" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
	</div>
</div>
@endsection