<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<form role="form">
			<div class="row">
				<div class="form-group">          
					<label for="profesor" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar profesor:</label>
					<div class="typeahead__container col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<div class="typeahead__field">             
							<span class="typeahead__query">
								<input class="profesores_typeahead form-control" name="profesor" type="search" placeholder="Nombre, Apellido, Número de documento" autocomplete="off" id="profesor">
							</span>
						</div>
					</div>
				</div> 
			</div>
		</form>
	</div>	
</div>
<br>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box box-default no-padding">
			<div class="box-header">
				<p>Profesores a cargo del curso.</p> 
			</div>
			<div class="box-body" style="display: none;">
				<table class="table table-striped" id="profesores-del-curso">
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
			input: '.profesores_typeahead',
			maxItem: 10,
			order: "desc",
			dynamic: true,
			delay: 500,
			backdrop: {
				"background-color": "#fff"
			},
			template: function (query, item) {
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
				return '<tr><td><a href="profesores"><i class="fa fa-plus text-green"></i><span>Crear profesor</span></a></td></tr>';
			},
			source: {
				Nombres: {
					display: 'apellidos',
					ajax:{
						url: "profesores/typeahead",
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
						url: "profesores/typeahead",
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
						url: "profesores/typeahead",
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
					profesor = '<tr>'+
					'<td>'+item.nombres+'</td>'+
					'<td>'+item.apellidos+'</td>'+
					'<td>'+item.documentos+'</td>'+
					'<td>'+
					'<span class="pull-right-container">'+
					'<div class="btn btn-xs btn-danger pull-right quitar"><i class="fa fa-minus"></i></div>'+
					'<div class="btn btn-xs btn-info pull-right"><a href="profesores/'+item.id+'"><i class="fa fa-search" data-id="'+item.id+'"></i></a></div>'+
					'</span>'+
					'</td>'+
					'</tr>';
					existe = false;
					$.each($('#profesores-del-curso tbody tr .fa-search'),function(k,v){
						if($(v).data('id') == item.id){
							existe = true;
						}
					});alta

					if(!existe){
						$('#profesores-del-curso tbody').append(profesor);	
						$('#profesores-del-curso').closest('div').show();						
					}
					$('#profesores .profesores_typeahead').val('');
				}
			},
			debug: true
		});

		$('#profesores-del-curso').on('click','.quitar', function(event) {
			this.closest('tr').remove();  
		});

	});

</script>