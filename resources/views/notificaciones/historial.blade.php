@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    @include('notificaciones.filter')
	<div id="scroll-historial-div">												
		@if( count($acciones))
        <ul class="timeline">
        <?php $last_date = null; ?>
        @foreach ($acciones as $accion)
            <?php $date = (new DateTime($accion->created_at))->format('d M Y'); ?>
            @if($date != $last_date)
			<li class="time-label">
				<span class="bg-blue">{{$date}}</span>
            </li>
            <?php $last_date = $date; ?>
            @endif
            <li>
               <i class="fa fa-graduation-cap text-blue" data-id="{{$accion->id_curso}}"></i>
                <div class="timeline-item">
                    <div class="timeline-body" style="background-color: #D8E4E8;">
                    	<span>{{ (new DateTime($accion->created_at))->format('H:i:s') }}</span>
						<b> | {{ $accion->provincia->nombre }} registro la edición {{ $accion->edicion }} de la acción </b>
                        <b> " {{ $accion->nombre }} "</b>
						<br>
					</div>
				</div>
			</li>
            @endforeach
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
		</ul>
		@else
		<div class="callout callout-warning">
			<h4>Sin datos!</h4>
			<p>No hubo actividad reciente en acciones.</p>
		</div>
		@endif
    </div>
    <br>
    <div id="scroll-historial-div">												
		@if( count($participantes))
        <ul class="timeline">
        <?php $last_date = null; ?>
        @foreach ($participantes as $participante)
            <?php $date = (new DateTime($participante->created_at))->format('d M Y'); ?>
            @if($date != $last_date)
			<li class="time-label">
				<span class="bg-blue">{{$date}}</span>
            </li>
            <?php $last_date = $date; ?>
            @endif
            <li>
               <i class="fa fa-user text-blue" data-id="{{$participante->id_alumno}}"></i>
                <div class="timeline-item">
                    <div class="timeline-body" style="background-color: #D8E4E8;">
	<span>{{ (new DateTime($participante->created_at))->format('H:i:s') }}</span>
						<b> | {{ $participante->provincia->nombre }} registro al participante </b>
						<b>" {{ $participante->nombres }} {{ $participante->apellidos }} "</b>
						<br>
					</div>
				</div>
			</li>
            @endforeach
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
		</ul>
		@else
		<div class="callout callout-warning">
			<h4>Sin datos!</h4>
			<p>No hubo actividad reciente en participantes.</p>
		</div>
		@endif
    </div>
    <br>
</div>
@endsection
@section('script')
@include('notificaciones.filter-script')
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
