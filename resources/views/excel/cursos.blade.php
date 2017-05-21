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
		<th class="table-header">Curso</th>
        <th class="table-header">Fecha</th>
        <th class="table-header">Edición</th>
        <th class="table-header">Duración</th>
        <th class="table-header">Area tematica</th>
        <th class="table-header">Linea estrategica</th>
        <th class="table-header">Provincia</th>
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