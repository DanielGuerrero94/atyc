<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
.table-header, p {
	font-size: 10px; 
	font-weight: bold; 
	text-align: center;
	background-color: #dee4e5;
}

.anio {
	font-size: 20px;
	font-weight: bold;
	text-align: center;
	background-color: #800080;
}

.provincia {
	font-size: 20px;
	font-weight: bold;
	background-color: #F79646;

td {
	font-size: 9px;
}
</style>

<table class="table">
	<tr>
		<th class="anio">{{"MATRIZ PAC - ".$pac->anio}}</th>
		<th class="provincia">{{"Jurisdicción: ".$pac->provincias->nombre}}</th>
	</tr>
	<tr>
		<th class="table-header">Fecha de Carga</th>
		<th class="table-header">Próxima Fecha Ejecución</th>
		<th class="table-header">Estado</th>
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
		<td>{{date('d/m/y', strtotime($pac->created_at))}}</td>
		<td>{{date('d/m/y', strtotime($pac->display_date))}}</td>
		<td>{{$pac->estado ? $pac->estado->nombre : 'No tiene estado'}}</td>
		<td>{{$pac->tipoAccion->numero ." ".$pac->tipoAccion->nombre}}</td>
		<td>{{(($pac->id_ficha_tecnica) ? (($pac->fichaTecnica->aprobada) ? ("Aprobada (".
		date('d/m/Y', strtotime($pac->fichaTecnica->updated_at)).")") : ("En diseño (".
		date('d/m/Y', strtotime($pac->fichaTecnica->created_at)).")")) : 'No tiene')." - ".
		($pac->ficha_obligatoria ? "Obligatoria" : "No Obligatoria")}}</td>
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
			<td>{{$componente->numero." - ".$componente->nombre}}
			@elseif ($loop->last)
			{{", ".$componente->numero." - ".$componente->nombre}}</td>
			@else
			{{", ".$componente->numero." - ".$componente->nombre}}
			@endif
		@endforeach
		@foreach($pac->pautas as $pauta)
			@if	($loop->first)
			<td>{{$pauta->numero." - ".$pauta->nombre}}
			@elseif ($loop->last)
			{{", ".$pauta->numero." - ".$pauta->nombre}}</td>
			@else
			{{", ".$pauta->numero." - ".$pauta->nombre}}
			@endif
		@endforeach
	</tr>
</table>
<br>
<table class="table">
	<tr>
		<th class="table-header">Acciones</th>
	</tr>
	<tr>
		<th class="table-header">Edición</th>
		<th class="table-header">Estado de Acción</th>
		<th class="table-header">Fecha Inicio Planificada</th>
		<th class="table-header">Fecha Inicio Ejecutada</th>
		<th class="table-header">Fecha Final Planificada</th>
		<th class="table-header">Fecha Final Ejecutada</th>
	</tr>
	@foreach($pac->cursos->sortBy('edicion') as $curso)
	<tr>
		<td>{{$curso->edicion}}</td>
		<td>{{$curso->estado->nombre}}</td>
		<td>{{$curso->fecha_plan_inicial}}</td>
		<td>{{$curso->fecha_ejec_inicial}}</td>
		<td>{{$curso->fecha_plan_final}}</td>
		<td>{{$curso->fecha_ejec_final}}</td>
	</tr>
	@endforeach
</table>