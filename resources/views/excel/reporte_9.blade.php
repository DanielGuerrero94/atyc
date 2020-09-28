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
		<th class="table-header">Periodo</th>
		<th class="table-header">Jurisdicción</th>
		<th class="table-header">Cantidad de Acciones con Ficha Técnica</th>
	</tr>
	@foreach($resultados as $resultado)
	<tr>
		<td>{{$resultado['periodo']}}</td>
		<td>{{$resultado['provincia']}}</td>
		<td>{{$resultado['cantidad_diseniadas']}}</td>
	</tr>
	@endforeach
</table>