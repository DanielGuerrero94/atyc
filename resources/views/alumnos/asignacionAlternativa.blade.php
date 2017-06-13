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
				console.log(item);
				return '<tr>'+				
				'<td>'+
				item.nombres+
				' '+
				item.apellidos+
				' '+				
				item.documentos+
				'</td>'+
				'</tr>';
			},
			dropdownFilter: "Filtro",
			emptyTemplate: function(){
				return '<tr><td><span>No hay resultados</span></td><br><td><i class="fa fa-plus text-green"></i><span>Crear alumno</span></td></tr>';
			},
			source: {
				Nombres: {
					display: 'apellidos',
					ajax:{
						url: "alumnos/typeahead/apellidos",
						path: "data.info",
						data: function(query){
							q: query;
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				Apellidos: {
					display: 'apellidos',
					ajax: {
						url: "alumnos/typeahead/apellidos",
						path: "data.info",
						data: function(query){
							q: query;
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				},
				Documentos: {
					display: 'documentos',
					ajax:{
						url: "alumnos/typeahead/apellidos",
						path: "data.info",
						data: function(query){
							q: query;
						},
						error: function(data){
							console.log("ajax error");
							console.log(data);
						}
					}
				}
			},
			callback: {
				onInit: function (node) {
					console.log('Typeahead Initiated on ' + node.selector);
				},
				onClick: function (node,  a, item, event) {
					alumno = '<tr>'+
					'<td>'+item.nombres+'</td>'+
					'<td>'+item.apellidos+'</td>'+
					'<td>'+item.documentos+'</td>'+
					'<td>'+
					'<span class="pull-right-container">'+
					'<div class="btn btn-xs btn-danger pull-right quitar"><i class="fa fa-minus"></i></div>'+
					'<div class="btn btn-xs btn-info pull-right"><a href="alumnos/'+item.id+'"><i class="fa fa-search" data-id="'+item.id+'"></i></a></div>'+
					'</span>'+
					'</td>'+
					'</tr>';
					existe = false;
					$.each($('#alumnos-del-curso tbody tr .fa-search'),function(k,v){
						if($(v).data('id') == item.id){
							existe = true;
						}
					});

					if(!existe){
						$('#alumnos-del-curso tbody').append(alumno);			
					}
					$('#alumnos .alumnos_typeahead').val('');
				}
			},
			debug: true
		});

		$('#alumnos-del-curso').on('click','.quitar', function(event) {
			this.closest('tr').remove();  
		});

	});

</script>