<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
.table-header, p {
	font-size: 10px; 
	font-weight: bold; 
	text-align: center;
	background-color: #dee4e5;
}

td {
	font-size: 9px;
}
</style>
<table class="table">	
	<tr>
		<th class="table-header">Fecha</th>
		<th class="table-header">Acción</th>
		<th class="table-header">Estado</th>
		<th class="table-header">Edición</th>
		<th class="table-header">Duración</th>
		<th class="table-header">Area temática</th>
		<th class="table-header">Tipo de acción</th>
		<th class="table-header">Jurisdicción</th>
		<th class="table-header">Fecha Planificación Inicial</th>
		<th class="table-header">Fecha Ejecución Inicial</th>
		<th class="table-header">Fecha Planificación Final</th>
		<th class="table-header">Fecha Ejecución Final</th>

	</tr>
	@foreach($cursos as $curso)
	<tr>
		<td>{{$curso['fecha_display']}}</td>
		<td>{{$curso['nombre']}}</td>
		<td>{{$curso['estado']['nombre']}}</td>
		<td>{{$curso['edicion']}}</td>
		<td>{{$curso['duracion']}}</td>
		<td>
		@foreach($curso['areas_tematicas'] as $tematica)
			@if	($loop->first)
			{{$tematica['nombre']}}
			@else
			{{", ".$tematica['nombre']}}
			@endif
		@endforeach
		</td>
		<td>{{$curso['linea_estrategica']['numero']." ".$curso['linea_estrategica']['nombre']}}</td>
		<td>{{$curso['provincia']['nombre']}}</td>
		<td>{{$curso['fecha_plan_inicial']}}</td>
		<td>{{$curso['fecha_ejec_inicial']}}</td>
		<td>{{$curso['fecha_plan_final']}}</td>
		<td>{{$curso['fecha_ejec_final']}}</td>
	</tr>
	@endforeach
</table>
