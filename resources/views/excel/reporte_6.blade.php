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
        <th class="table-header">Edición</th>
        <th class="table-header">Fecha</th>
        <th class="table-header">Cantidad</th>
        <th class="table-header">Linea Estratégica</th>
        <th class="table-header">Area Temática</th>
        <th class="table-header">Provincia</th>
        <th class="table-header">Duración</th>
	</tr>
	@foreach($cursos as $curso)
		<tr>
			<td>{{$curso->nombre}}</td>
			<td>{{$curso->edicion}}</td>
			<td>{{$curso->fecha}}</td>
			<td>{{$curso->cantidad_alumnos}}</td>
			<td>{{$curso->linea_estrategica}}</td>
			<td>{{$curso->area_tematica}}</td>
			<td>{{$curso->provincia}}</td>
			<td>{{$curso->duracion}}</td>
		</tr>
	@endforeach
</table>