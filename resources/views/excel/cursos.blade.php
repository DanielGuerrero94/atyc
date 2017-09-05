<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/excel.css') }}">

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
			<td>{{$curso->fecha}}</td>
			<td>{{$curso->edicion}}</td>
			<td>{{$curso->duracion}}</td>
			<td>{{$curso->area_tematica}}</td>
			<td>{{$curso->linea_estrategica}}</td>
			<td>{{$curso->provincia}}</td>
		</tr>
	@endforeach
</table>