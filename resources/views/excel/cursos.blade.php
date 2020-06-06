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
		<th class="table-header">Acción</th>
		<th class="table-header">Fecha</th>
		<th class="table-header">Edición</th>
		<th class="table-header">Duración</th>
		<th class="table-header">Area temática</th>
		<th class="table-header">Tipo de acción</th>
		<th class="table-header">Jurisdicción</th>
	</tr>
	@foreach($cursos as $curso)
	<tr>
		<td>{{$curso->nombre}}</td>
		<td>{{$curso->fecha_ejec_inicial}}</td>
		<td>{{$curso->edicion}}</td>
		<td>{{$curso->duracion}}</td>
		<td>{{$curso->areaTematica->nombre}}</td>
		<td>{{$curso->lineaEstrategica->numero ." ".$curso->lineaEstrategica->nombre}}</td>
		<td>{{$curso->provincia->nombre}}</td>
	</tr>
	@endforeach
</table>
