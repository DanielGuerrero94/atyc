<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
.table-header, p {
	font-size: 10px; 
	font-weight: bold; 
	text-align: center;
	background-color: #dee4e5;
}

.fechas {
    font-size: 10px; 
	font-weight: bold; 
	text-align: center;
	background-color: #00CED1;
}

td {
	font-size: 9px;
}
</style>

<table class="table">
	<tr>
		<th class="table-header">Fecha de Carga</th>
		<th class="table-header">Fecha Próxima Ejecución</th>
		<th class="table-header">Estado</th>
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
		<th class="table-header">Pautas para PAC</th>
		@for($i = 1; ($i <= count($pacs->sortByDesc('ediciones')->first()->cursos)); $i++)
		<th class="fechas">{{"Edición ". $i." - Estado - [Fecha Inicial-Final]"}}</th>
		@endfor
	</tr>
    @foreach($pacs as $pac)
	<tr>
		<td>{{date('d/m/y', strtotime($pac->created_at))}}</td>
		<td>{{date('d/m/y', strtotime($pac->display_date))}}</td>
		<td>{{$pac->estado ? $pac->estado->nombre : 'No tiene estado'}}</td>
		<td>{{$pac->provincias->nombre}}</td>
		<td>{{$pac->tipoAccion->numero ." ".$pac->tipoAccion->nombre}}</td>
		<td>{{(($pac->id_ficha_tecnica) ? (($pac->fichaTecnica->aprobada) ? ("Aprobada (".
		date('d/m/Y', strtotime($pac->fichaTecnica->updated_at)).")") : ("En diseño (" .
		date('d/m/Y', strtotime($pac->fichaTecnica->created_at))).")") : 'No tiene')." - ".
		($pac->ficha_obligatoria ? "Obligatoria" : "No Obligatoria")
		}}</td>
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
		@foreach($pac->cursos as $curso)
        <td>
        {{$curso->edicion." - ".$curso->estado->nombre.". ".
		((in_array($curso->estado->id_estado, [1,2,5,6])) ? 
		("Fechas Planificadas:[".date('d/m', strtotime($curso->fecha_plan_inicial))." - ".
        date('d/m', strtotime($curso->fecha_plan_final))."]") :
		("Fechas Ejecución:[".($curso->fecha_ejec_inicial ? (date('d/m', strtotime($curso->fecha_ejec_inicial))." - ") : " ").
        ($curso->fecha_ejec_final ? (date('d/m', strtotime($curso->fecha_ejec_final))) : " ")."]"))}}
        </td>
		@endforeach
	</tr>
    @endforeach
</table>