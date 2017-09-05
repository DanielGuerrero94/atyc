<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/excel.css') }}">

<table class="table">	
	<tr>
		<th class="table-header">Nombres</th>
        <th class="table-header">Apellidos</th>
        <th class="table-header">Tipo Documento</th>
        <th class="table-header">Número Documento</th>
        <th class="table-header">Tipo Docente</th>
        <th class="table-header">Email</th>
        <th class="table-header">Tel</th>
        <th class="table-header">Cel</th>
	</tr>
	@foreach($profesores as $profesor)
		<tr>
			<td>{{$profesor->nombres}}</td>
			<td>{{$profesor->apellidos}}</td>
			<td>{{$profesor->tipo_doc}}</td>
			<td>{{$profesor->nro_doc}}</td>
			<td>{{$profesor->tipo_docente}}</td>
			<td>{{$profesor->email}}</td>
			<td>{{$profesor->tel}}</td>
			<td>{{$profesor->cel}}</td>
		</tr>
	@endforeach
</table>