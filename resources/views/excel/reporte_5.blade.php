<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/excel.css') }}">

<table class="table">	
	<tr>
		<th class="table-header">Periodo</th>
		<th class="table-header">Jurisdiccion</th>
		<th class="table-header">Curso</th>
		<th class="table-header">Edición</th>
		<th class="table-header">Fecha</th>
		<th class="table-header">Cantidad de participantes</th>
		<th class="table-header">Tipo de accion</th>
		<th class="table-header">Area Temática</th>
		<th class="table-header">Duración</th>
	</tr>
	@foreach($resultados as $resultado)
	<tr>
	<td>{{$resultado->periodo}}</td>
		<td>{{$resultado->provincia}}</td>
		<td>{{$resultado->nombre}}</td>
		<td>{{$resultado->edicion}}</td>si
		<td>{{$resultado->fecha}}</td>
		<td>{{$resultado->cantidad_alumnos}}</td>
		<td>{{$resultado->tipologia}}</td>
		<td>{{$resultado->tematica}}</td>
		<td>{{$resultado->duracion}}</td>
	</tr>
	@endforeach
</table>