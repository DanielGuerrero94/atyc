<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<form role="form">
			<div class="row">
				<div class="form-group">          
					<label for="alumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar alumno:</label>
					<div class="typeahead__container col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<div class="typeahead__field">             
							<span class="typeahead__query">
								<input class="alumnos_typeahead form-control" name="alumno" type="search" placeholder="Nombre, Apellido, Número de documento" autocomplete="off" id="alumno">
							</span>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="btn-group pull-right">				
				<button type="button" class="btn btn-default" id="crear-alumno" disabled>Crear</button>
				<button type="submit" class="btn btn-info" id="buscar-alumno">Buscar</button>
			</div> -->
		</form>
	</div>	
</div>
<br>
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<div class="box box-default no-padding">
			<div class="box-header">
				<p>Alumnos en el curso.</p>
			</div>
			<div class="box-body">
				<table class="table table-striped" id="alumnos-del-curso">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Documento</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		/*$('button').on('click',function(event) {
			event.preventDefault();
			var row = '<tr><td>Testing</td><td>Test</td><td>Mock</td></tr>';
			$('#alumnos-del-curso tbody').append(row);
		});*/

		$('#buscar-alumno').on('click', function(event) {
			event.preventDefault();
			//Agarro un dato que me ayude a buscarlo
			search = $('.alumnos_typeahead').val();
			//Traigo los datos para poner en la tabla
			$.ajax({
				url: 'alumnos/buscar/'+search,
				type: 'get',
				data: {param1: 'value1'},
				complete: function(xhr, textStatus) {
			    //called when complete
			},
			success: function(data, textStatus, xhr) {
				//Caso contrario aparece el boton agregar y se agrega a la tabla de abajo

				//Guardo en el boton de info el id
				//alumnos = data;
				alumno = '<tr>'+
				'<td>Daniel</td>'+
				'<td>Guerrero</td>'+
				'<td>38324239</td>'+
				'<td>'+
				'<span><i class="fa fa-search bg-aqua" data-id="12"></i></span>'+
				'<span><i class="fa fa-minus bg-red"></i></span>'+
				'</td>'+
				'</tr>';
				$('#alumnos-del-curso tbody').append(alumno);
			},
			error: function(xhr, textStatus, errorThrown) {
			    //called when there is an error
			}
		});
			
			//Si no hay nada muestro el boton de crear alumno y lo tiro en un dialog
		});

		alumno = '<tr>'+
		'<td>Daniel</td>'+
		'<td>Guerrero</td>'+
		'<td>38324239</td>'+
		'<td>'+
		'<span class="pull-right-container">'+
		'<button class="btn btn-xs btn-danger pull-right"><i class="fa fa-minus"></i></button>'+
		'<button class="btn btn-xs btn-info pull-right"><i class="fa fa-search" data-id="12"></i></button>'+
		'</span>'+
		'</td>'+
		'</tr>';
		$('#alumnos-del-curso tbody').append(alumno);

		$.typeahead({
			input: '.alumnos_typeahead',
			maxItem: 10,
			order: "desc",
			dynamic: true,
			delay: 500,
			backdrop: {
				"background-color": "#fff"
			},
			template: function (query, item) {
				console.log(query);
				console.log(item);
				return '<span class="row">'+
				'<p>'+item.display+'</p>'+
				'</span>'
			},
			dropdownFilter: "Filtro",
			emptyTemplate: 'No hay resultados',
			source: {
				Nombres: {
					ajax: {
						url: "alumnos/typeahead/nombres",
						path: "data.info",
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				Apellidos: {
					ajax: {
						url: "alumnos/typeahead/apellidos",
						path: "data.info",
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				Documento: {
					ajax: {
						url: "alumnos/typeahead/documentos",
						path: "data.info",
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
			},
			callback: {
				onInit: function (node) {
					console.log('Typeahead Initiated on ' + node.selector);
				},
				onClick: function (node,  a, item, event) {
					alert(JSON.strigify(item));
				}
			},
			debug: true
		});

	});
</script>