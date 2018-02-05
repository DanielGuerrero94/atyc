@extends('layouts.adminlte')

@section('content')
<style>
.button {
	display: inline-block;
	border-radius: 4px;
	background-color: #f4511e;
	border: none;
	color: #FFFFFF;
	text-align: center;
	font-size: 28px;
	padding: 20px;
	width: 200px;
	transition: all 0.5s;
	cursor: pointer;
	margin: 5px;
}

.button span {
	cursor: pointer;
	display: inline-block;
	position: relative;
	transition: 0.5s;
}

.button span:after {
	content: '\00bb';
	position: absolute;
	opacity: 0;
	top: 0;
	right: -20px;
	transition: 0.5s;
}

.button:hover span {
	padding-right: 25px;
}

.button:hover span:after {
	opacity: 1;
	right: 0;
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-8 col-lg-6">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Datos del efector: {{ $efector->nombre }}
						<div class="btn-group pull-right" role="group" aria-label="...">
							<a href="http://200.69.210.3/sirge3/public/login" class="btn btn-square" title="Ver en SIRGE">
								<i class="fa fa-link text-primary fa-lg"> SIRGE</i>
							</a>
						</div>
					</h2>
				</div>
				<div class="box-body">
					<form class="form-horizontal">
						<hr>
						<h4><b>Información general</b></h4>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Nombre</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->nombre }}</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Denominación legal</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->denominacion_legal }}</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Siisa</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->siisa }}</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Cuie</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->cuie }}</p>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<h4><b>Domicilio</b></h4>
						<div class="row">						
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Provincia</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->provincia }}</p>
									</div>
								</div>
							</div>	
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Ciudad</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->ciudad }}</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Departamento</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->departamento }}</p>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Localidad</label>
									<div class="col-sm-8">
										<p class="form-control-static">{{ $efector->localidad }}</p>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
						<a href='{{url("/efectores")}}'><button class="btn btn-warning"><i class="fa fa-undo"></i>Volver</button></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Historial: {{ $efector->nombre }}</h2>
				</div>
				<div class="box-body">				
					<div id="scroll-historial-div">												
						<h4>Cursos realizados</h4>
						@if( count($cursos))
						<ul class="timeline">
							@foreach ($cursos as $curso)
							<li class="time-label">
								<span class="bg-blue">{{ $curso->fecha }}</span>
							</li>
							<li>
								<i class="fa fa-graduation-cap text-blue"></i>
								<div class="timeline-item">
									<div class="timeline-body" style="background-color: #D8E4E8;">
										<b>{{ $curso->nombre }}</b>
										<br>
										<span>Cantidad de alumnos: {{ $curso->alumnos }}  </span>
										<a href='{{url("/cursos/$curso->id_curso")}}'><span class="btn btn-info btn-xs">Detalles</span></a>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
						@else
						<div class="callout callout-warning">
							<h4>Sin datos!</h4>
							<p>No participó de ningún curso.</p>
						</div>
						@endif
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){

		$('#scroll-historial-div').slimScroll({
			height: '450px'
		});

	});
</script>
@endsection