@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div id="scroll-historial-div">												
		@if( count($acciones))
		<ul class="timeline">
        @foreach ($acciones as $accion)
            @if(true)
			<li class="time-label">
				<span class="bg-blue">{{ (new DateTime($accion->created_at))->format('y-m-d') }}</span>
            </li>
            @endif
            <li>
<!--<a href="{{url('/cursos').'/'.$accion->id_curso}}" title="Ver en detalle">-->
                            <i class="fa fa-graduation-cap text-blue" data-id="{{$accion->id_curso}}"></i>
<!--</a>-->
                <div class="timeline-item">
                    <div class="timeline-body" style="background-color: #D8E4E8;">
	<span>{{ (new DateTime($accion->created_at))->format('H:i:s') }}</span>
						<b> | {{ $accion->provincia->nombre }} creo </b>
						<b>" {{ $accion->nombre }} "</b>
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
			height: '100%'
    });

        $(".container-fluid").on("click", ".fa-graduation-cap", function () {
            location.href= "{{url('/cursos').'/'}}" + $(this).data('id');
        });

	});
</script>
@endsection
