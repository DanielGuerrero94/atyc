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
		<th class="table-header">Fecha de Planificación</th>
		<th class="table-header">Jurisdicción</th>
		<th class="table-header">Tipo de Acción</th>
		<th class="table-header">Ficha Técnica</th>
		<th class="table-header">Nombre</th>
		<th class="table-header">Duración</th>
		<th class="table-header">Destinatarios</th>
		<th class="table-header">Temática/s</th>
		<th class="table-header">Cantidad de ediciones</th>
		<th class="table-header">Responsable de la Ejecución</th>
		<th class="table-header">Asociación componente del CA</th>
		<th class="table-header">Tabla de Pautas para PAC</th>
	</tr>
	<tr>
		<td>{{$pac->created_at}}</td>
		<td>{{$pac->provincias->nombre}}</td>
		<td>{{$pac->tipoAccion->numero ." ".$pac->tipoAccion->nombre}}</td>
		<td>{{($pac->id_ficha_tecnica) ? (($pac->fichaTecnica->aprobada) ? ("Aprobada (".
		date('d/m/Y', strtotime($pac->fichaTecnica->updated_at)).")") : ("En diseño (".
		date('d/m/Y', strtotime($pac->fichaTecnica->created_at)).")")) : 'No tiene'}}</td>
		<td>{{$pac->nombre}}</td>
		<td>{{$pac->duracion}}</td>
		@foreach($pac->destinatarios as $destinatario)
			@if	($loop->first)
			<td>{{$destinatario->nombre}}
			@elseif ($loop->last)
			{{", ".$destinatario->nombre}}</td>
			@else
			{{", ".$destinatario->nombre}}
			@endif
		@endforeach
		@foreach($pac->tematicas as $tematica)
			@if	($loop->first)
			<td>{{$tematica->nombre}}
			@elseif ($loop->last)
			{{", ".$tematica->nombre}}</td>
			@else
			{{", ".$tematica->nombre}}
			@endif
		@endforeach
		<td>{{$pac->ediciones}}</td>
		@foreach($pac->responsables as $responsable)
			@if	($loop->first)
			<td>{{$responsable->nombre}}
			@elseif ($loop->last)
			{{", ".$responsable->nombre}}</td>
			@else
			{{", ".$responsable->nombre}}
			@endif
		@endforeach
		@foreach($pac->componentes as $componente)
			@if	($loop->first)
			<td>{{$componente->nombre}}
			@elseif ($loop->last)
			{{", ".$componente->nombre}}</td>
			@else
			{{", ".$componente->nombre}}
			@endif
		@endforeach
		@foreach($pac->pautas as $pauta)
			@if	($loop->first)
			<td>{{$pauta->nombre}}
			@elseif ($loop->last)
			{{", ".$pauta->nombre}}</td>
			@else
			{{", ".$pauta->nombre}}
			@endif
		@endforeach
	</tr>
</table>
<br>
<p>Acciones</p>
<table class="table">	
	<tr>
		<th class="table-header">Edición</th>
		<th class="table-header">Estado de Acción</th>
		<th class="table-header">Fecha Inicio Planificada</th>
		<th class="table-header">Fecha Final Planificada</th>
		<th class="table-header">Fecha Inicio Ejecutada</th>
		<th class="table-header">Fecha Final Ejecutada</th>
	</tr>
	@foreach($pac->cursos as $curso)
	<tr>
		<td>{{$curso->edicion}}</td>
		<td>{{$curso->estado->nombre}}</td>
		<td>{{$curso->fecha_plan_inicial}}</td>
		<td>{{$curso->fecha_plan_final}}</td>
		<td>{{$curso->fecha_ejec_inicial}}</td>
		<td>{{$curso->fecha_ejec_final}}</td>
	</tr>
	@endforeach
</table>