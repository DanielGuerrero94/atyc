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

</style>

<table class="table">	
	<tr>
		<th class="table-header">Nombres</th>
        <th class="table-header">Apellidos</th>
        <th class="table-header">Tipo Doc</th>
        <th class="table-header">Nro Doc</th>
        @if(Auth::user()->id_provincia == 25)
        <th class="table-header">Provincia</th>
        @endif
	</tr>
	@if(Auth::user()->id_provincia == 25)
		@foreach($alumnos as $alumno)
		<tr>
			<td>{{$alumno->nombres}}</td>
			<td>{{$alumno->apellidos}}</td>
			<td>{{$alumno->id_tipo_documento}}</td>
			<td>{{$alumno->nro_doc}}</td>
			<td>{{$alumno->provincia}}</td>
		</tr>
		@endforeach
	@else
		@foreach($alumnos as $alumno)
		<tr>
			<td>{{$alumno->nombres}}</td>
			<td>{{$alumno->apellidos}}</td>
			<td>{{$alumno->id_tipo_documento}}</td>
			<td>{{$alumno->nro_doc}}</td>
		</tr>
		@endforeach
	@endif
</table>