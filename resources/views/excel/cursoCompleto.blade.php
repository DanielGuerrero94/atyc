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
		<th class="table-header">Nombre</th>
		<th class="table-header">Fecha</th>
		<th class="table-header">Edición</th>
		<th class="table-header">Duración</th>
		<th class="table-header">Area temática</th>
		<th class="table-header">Tipo de acción</th>
		<th class="table-header">Jurisdicción</th>
	</tr>
	<tr>
		<td>{{$curso->nombre}}</td>
		<td>{{$curso->fecha_ejec_final}}</td>
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
		<th class="table-header">Número de documento</th>
		<th class="table-header">Género</th>
		<th class="table-header">Jurisdicción</th>
		<th class="table-header">Localidad</th>
		<th class="table-header">Trabajo</th>
		<th class="table-header">Efector</th>
		<th class="table-header">Establecimiento</th>
		<th class="table-header">Tipo de organismo</th>
		<th class="table-header">Organismo</th>
		<th class="table-header">Rol</th>
		<th class="table-header">Email</th>
		<th class="table-header">Tel</th>
		<th class="table-header">Cel</th>
	</tr>
	@foreach($curso->alumnos as $alumno)
	<tr>
		<td>{{$alumno->nombres}}</td>
		<td>{{$alumno->apellidos}}</td>
		<td>{{$alumno->tipoDocumento->nombre}}</td>
		<td>{{$alumno->nro_doc}}</td>
		<td>{{$alumno->genero->nombre}}</td>
		<td>{{$alumno->provincia->nombre}}</td>
		<td>{{$alumno->localidad}}</td>
		<td>{{$alumno->trabajo->nombre}}</td>
		<td>{{$alumno->establecimiento1}}</td>
		<td>{{$alumno->establecimiento2}}</td>
		<td>{{$alumno->organismo1}}</td>
		<td>{{$alumno->organismo2}}</td>
		<td>{{$alumno->funcion->nombre}}</td>
		<td>{{$alumno->email}}</td>
		<td>{{$alumno->tel}}</td>
		<td>{{$alumno->cel}}</td>
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
		<th class="table-header">Número de documento</th>
		<th class="table-header">Tipo de docente</th>
		<th class="table-header">Email</th>
		<th class="table-header">Tel</th>
		<th class="table-header">Cel</th>
	</tr>
	@foreach($curso->profesores as $profesor)
	<tr>
		<td>{{$profesor->nombres}}</td>
		<td>{{$profesor->apellidos}}</td>
		<td>{{$profesor->tipoDocumento->nombre}}</td>
		<td>{{$profesor->nro_doc}}</td>
		<td>{{$profesor->tipoDocente->nombre}}</td>
		<td>{{$profesor->email}}</td>
		<td>{{$profesor->tel}}</td>
		<td>{{$profesor->cel}}</td>
	</tr>
	@endforeach
</table>