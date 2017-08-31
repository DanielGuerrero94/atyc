<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">

	.table-header {
		font-size: 10px; 
		font-weight: bold; 
		text-align: center;
		background-color: #dee4e5;
	}

	td {
		font-size: 9px;
	}

	p {
		font-size: 9px; 
		font-weight: bold; 
		text-align: center;
		background-color: #dee4e5;
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
	<tr>
		<td>{{$curso->nombre}}</td>
		<td>{{$curso->fecha}}</td>
		<td>{{$curso->edicion}}</td>
		<td>{{$curso->duracion}}</td>
		<td>{{$curso->areaTematica->nombre}}</td>
		<td>{{$curso->lineaEstrategica->numero}} - {{$curso->lineaEstrategica->nombre}}</td>
		<td>{{$curso->provincia->nombre}}</td>
	</tr>
</table>
<br>
<p>Participantes</p>
<table class="table">	
	<tr>
		<th class="table-header">Nombres</th>
		<th class="table-header">Apellidos</th>
		<th class="table-header">Tipo de documento</th>
		<th class="table-header">Numero de documento</th>
		<th class="table-header">Jurisdicción</th>
	</tr>
	@foreach($curso->alumnos as $alumno)
	<tr>
		<td>{{$alumno->nombres}}</td>
		<td>{{$alumno->apellidos}}</td>
		<td>{{$alumno->tipoDocumento->nombre}}</td>
		<td>{{$alumno->nro_doc}}</td>
		<td>{{$alumno->provincia->nombre}}</td>
	</tr>
	@endforeach
</table>
<br>
<p>Docentes</p>
<table class="table">	
	<tr>
		<th class="table-header">Nombres</th>
		<th class="table-header">Apellidos</th>
		<th class="table-header">Tipo de documento</th>
		<th class="table-header">Numero de documento</th>
	</tr>
	@foreach($curso->profesores as $profesor)
	<tr>
		<td>{{$profesor->nombres}}</td>
		<td>{{$profesor->apellidos}}</td>
		<td>{{$profesor->tipoDocumento->nombre}}</td>
		<td>{{$profesor->nro_doc}}</td>
	</tr>
	@endforeach
</table>