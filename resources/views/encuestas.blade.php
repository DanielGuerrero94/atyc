@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table id="table" class="table table-hover">
				<thead>
					<tr>
						<th>Curso</th>
						<th>Pregunta</th>
						<th>Respuesta</th>
						<th>Cantidad</th>
						<th>Id</th>
						<th>Indicador</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		console.log("El documento se cargo");

			$('#table').DataTable({
			data: {!! $encuestas !!},
			columns: [
			{ data: 'curso'},
			{ data: 'pregunta'},
			{ data: 'respuesta'},
			{ data: 'cantidad'},
			{ data: 'id'},
			{ data: 'indicador'}
			]
		});

		console.log("Se creo la tabla");
	})

</script> 

@endsection

