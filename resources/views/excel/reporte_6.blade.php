<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/excel.css') }}">

<table class="table">	
	<tr>
		<th class="table-header">Periodo</th>
		<th class="table-header">Jurisdicción</th>
		<th class="table-header">CUIE</th>
		<th class="table-header">Efector</th>
		<th class="table-header">Denominacion legal</th>
		<th class="table-header">Departamento</th>
		<th class="table-header">Localidad</th>
		<th class="table-header">Accion</th>
		<th class="table-header">Fecha</th>
		<th class="table-header">Participantes</th>
	</tr>
	@foreach($resultados as $resultado)
	<tr>
		<td>{{$resultado->periodo}}</td>
		<td>{{$resultado->provincia}}</td>
		<td>{{$resultado->cuie}}</td>
		<td>{{$resultado->efector}}</td>
		<td>{{$resultado->denominacion_legal}}</td>
		<td>{{$resultado->departamento}}</td>
		<td>{{$resultado->localidad}}</td>
		<td>{{$resultado->accion}}</td>
		<td>{{$resultado->fecha}}</td>
		<td>{{$resultado->participantes}}</td>
	</tr>
	@endforeach
</table>