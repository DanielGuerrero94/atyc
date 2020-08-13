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
		<th class="table-header">Período</th>
        <th class="table-header">Provincia</th>
        <th class="table-header">Capacitados</th>
        <th class="table-header">Total efectores</th>
        <th class="table-header">Porcentaje</th>
	</tr>
	@foreach($resultados as $resultado)
		<tr>
			<td>{{$resultado['periodo']}}</td>
			<td>{{$resultado['provincia']}}</td>
			<td>{{$resultado['capacitados']}}</td>
			<td>{{$resultado['total']}}</td>
			<td>{{$resultado['porcentaje']}}%</td>
		</tr>
	@endforeach
</table>
