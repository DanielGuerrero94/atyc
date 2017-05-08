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
	</tr>
	@foreach($profesores as $profesor)
		<tr>
			<td>{{$profesor->nombres}}</td>
			<td>{{$profesor->apellidos}}</td>
			<td>{{$profesor->tipo_doc}}</td>
			<td>{{$profesor->nro_doc}}</td>
		</tr>
	@endforeach
</table>