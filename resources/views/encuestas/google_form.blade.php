@extends('layouts.adminlte')
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">	
		<div class="alert alert-warning alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4 style="color: rgb(0,0,0);"><i class="icon fa fa-warning"></i> Aclaración</h4>
			<span style="color: rgb(0,0,0);">Este formulario es el que veria el alumno y puede completar el resultado se muestra en otra pestaña.
				El diseño del formulario se clona y se le asiga a otros cursos.
			</span>
		</div>
	</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">	
		<div class="box box-default">
			<div class="box-header with-border text-center">		
				<div class="box-title">
					<p>Encuesta</p>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdGQtX_lXyTCyHpoHbFW9eh34vGBXt_uINWhDT6qPXqdk_ytA/viewform?embedded=true" width="100%" height="600" frameborder="0" marginheight="0" marginwidth="0">Cargando...</iframe>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>	
@endsection
