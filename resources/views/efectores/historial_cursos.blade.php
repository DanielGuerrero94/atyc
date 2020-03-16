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
					<a href="{{url('/efectores')}}" class="btn pull-left" id="back" title="Volver"><i class="fa fa-arrow-left"></i></a>
					<h3 class="box-tittle" style="margin-top: 5px;"> Datos del efector</h3>
					<div class="box-tools pull-right" style="margin-top: 5px;">
						<a href="http://170.150.155.102/sirge3/public/login" class="btn btn-square" title="Ver en SIRGE">
							<i class="fa fa-link text-primary fa-lg"> SIRGE</i>
						</a>
					</div>
				</div>
				<div class="box-body">
					<form class="form-horizontal">
						<hr>
						<h4><b>Información general</b></h4>
						<hr>
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
						<hr>
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
										<p class="form-control-static">{{ isset($efector->ciudad) }}</p>
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
            </div>
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-tittle" style="margin-top: 10px;"> Participantes</h3>
                </div>
                <div class="box-body">
                    <table id="participantes-table" class="table table-hover"></table>
                </div>
            </div>            
		</div>
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-6">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-tittle" style="margin-top: 5px;"> Historial de acciones</h3>
				</div>
				<div class="box-body">				
					<div id="scroll-historial-div">												
						<hr>
						<h4><b>Acciones en las que formo parte</b></h4>
						<hr>
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
										<a href="{{url('/cursos').'/'.$curso->id_curso.'/see'}}" class="btn btn-square pull-right" title="Ver en detalle">
											<i class="fa text-primary fa-lg"> Ver en detalle</i>
										</a>
										<b>{{ $curso->nombre }}</b>
										<br>
										<span>Cantidad de alumnos: <span class="label label-primary">{{ $curso->alumnos }}</span></span>										
									</div>
								</div>
							</li>
							@endforeach
						</ul>
						@else
						<div class="callout callout-warning">
							<h4>Sin datos!</h4>
							<p>No participó de ninguna acción de capacitación.</p>
						</div>
						@endif
					</div>				
				</div>
            </div>
	</div>
    </div>
    <div class="row">
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

	function seeButton(id_alumno) {
		return '<a href="{{url("/alumnos")}}/' + id_alumno + '/see" data-id="' + id_alumno + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}

	function editButton(id_alumno) {
		return '<a href="{{url("/alumnos")}}/' + id_alumno + '" data-id="' + id_alumno + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	$(document).ready(function(){

		$('#scroll-historial-div').slimScroll({
			height: '1058px'
		});

		$('#participantes-table').DataTable({
			destroy: true,
			ajax : "{{url('/efectores')}}/" + "{{$efector->cuie}}" + "/participantes",
			columns: [
			{ title: 'Nombres', data: 'nombres'},
			{ title: 'Apellidos', data: 'apellidos'},
			{ title: 'Nro Doc', data: 'nro_doc'},
			{ title: 'Email', data: 'email'},
			{ title: 'Rol', data: 'funcion', name: 'funcion'},
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
					return seeButton(row.id_alumno) + editButton(row.id_alumno);
				},
				searchable: false,
				orderable: false

			}
			],
			responsive: true
		});

	});
</script>
@endsection
