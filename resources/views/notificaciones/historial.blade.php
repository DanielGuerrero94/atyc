@extends('layouts.adminlte')

@section('content')
<div class="row">
	<div id="scroll-historial-div">												
		@if( count($acciones))
		<ul class="timeline">
			@foreach ($acciones as $accion)
			<li class="time-label">
				<span class="bg-blue">{{ $accion->created_at }}</span>
			</li>
			<li>
				<i class="fa fa-graduation-cap text-blue"></i>
				<div class="timeline-item">
					<div class="timeline-body" style="background-color: #D8E4E8;">
						<a href="{{url('/cursos').'/'.$curso->id_curso}}" class="btn btn-square pull-right" title="Ver en detalle">
							<i class="fa text-primary fa-lg"> Ver en detalle</i>
						</a>
						<b>{{ $accion->provincia->nombre }} creo </b>
						<b>{{ $accion->nombre }}</b>
						<br>
					</div>
				</div>
			</li>
			@endforeach
		</ul>
		@else
		<div class="callout callout-warning">
			<h4>Sin datos!</h4>
			<p>No hubo actividad reciente en acciones.</p>
		</div>
		@endif
	</div>				
</div>
@endsection
@section('script')
<script type="text/javascript">

	function seeButton(id_alumno) {
		return '<a href="{{url("/alumnos")}}/' + id_alumno + '/see" data-id="' + id_alumno + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-eye text-info fa-lg"></i></a>';
	}

	$(document).ready(function(){

		$('#scroll-historial-div').slimScroll({
			height: '430px'
		});

	});
</script>
@endsection