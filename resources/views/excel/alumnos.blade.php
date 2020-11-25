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
		<th class="table-header">Nombres</th>
        <th class="table-header">Apellidos</th>
        <th class="table-header">Tipo Doc</th>
        <th class="table-header">Nro Doc</th>
        <th class="table-header">Género</th>
        @if(Auth::user()->id_provincia == 25)
        <th class="table-header">Provincia</th>
        @endif
        <th class="table-header">Localidad</th>
        <th class="table-header">Trabajo</th>
        <th class="table-header">Función</th>
        <th class="table-header">Establecimiento 1</th>
        <th class="table-header">Establecimiento 2</th>
        <th class="table-header">Organismo 1</th>
        <th class="table-header">Organismo 2</th>
        <th class="table-header">Email</th>
        <th class="table-header">Celular</th>
        <th class="table-header">Teléfono</th>
	</tr>
	@if(Auth::user()->id_provincia == 25)
		@foreach($alumnos as $alumno)
		<tr>
			<td>{{$alumno->nombres}}</td>
			<td>{{$alumno->apellidos}}</td>
			<td>{{$alumno->tipo_documento}}</td>
			<td>{{$alumno->nro_doc}}</td>
			<td>{{$alumno->genero}}</td>
			<td>{{$alumno->provincia}}</td>
			<td>{{$alumno->localidad}}</td>
			<td>{{$alumno->trabajo}}</td>
			<td>{{$alumno->funcion}}</td>
			<td>{{$alumno->establecimiento1}}</td>
			<td>{{$alumno->establecimiento2}}</td>
			<td>{{$alumno->organismo1}}</td>
			<td>{{$alumno->organismo2}}</td>
			<td>{{$alumno->email}}</td>
			<td>{{$alumno->cel}}</td>
			<td>{{$alumno->tel}}</td>
		</tr>
		@endforeach
	@else
		@foreach($alumnos as $alumno)
		<tr>
			<td>{{$alumno->nombres}}</td>
			<td>{{$alumno->apellidos}}</td>
			<td>{{$alumno->id_tipo_documento}}</td>
			<td>{{$alumno->nro_doc}}</td>
			<td>{{$alumno->genero}}</td>
			<td>{{$alumno->localidad}}</td>
			<td>{{$alumno->trabajo}}</td>
			<td>{{$alumno->funcion}}</td>
			<td>{{$alumno->establecimiento1}}</td>
			<td>{{$alumno->establecimiento2}}</td>
			<td>{{$alumno->organismo1}}</td>
			<td>{{$alumno->organismo2}}</td>
			<td>{{$alumno->email}}</td>
			<td>{{$alumno->cel}}</td>
			<td>{{$alumno->tel}}</td>
		</tr>
		@endforeach
	@endif
</table>
