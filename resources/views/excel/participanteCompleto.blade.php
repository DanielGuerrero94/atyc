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
		<th class="table-header">Apellido</th>
		<th class="table-header">Tipo documento</th>
		<th class="table-header">Número</th>
		<th class="table-header">Genero</th>
	</tr>
	<tr>
		<td>{{$participante->nombres}}</td>
		<td>{{$participante->apellidos}}</td>
		<td>{{$participante->tipoDocumento->nombre}}</td>
		<td>{{$participante->nro_doc}}</td>
		<td>{{$participante->nro_doc}}</td>
	</tr>
</table>