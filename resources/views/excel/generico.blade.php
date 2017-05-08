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
		<th class="table-header">CURSO</th>
        <th class="table-header">EDICIÓN</th>
        <th class="table-header">FECHA</th>
        <th class="table-header">CANTIDAD</th>
        <th class="table-header">LINEA ESTRATÉGICA</th>
        <th class="table-header">AREA TEMÁTICA</th>
        <th class="table-header">PROVINCIA</th>
        <th class="table-header">DURACIÓN</th>
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