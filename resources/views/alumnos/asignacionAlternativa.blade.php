<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<form role="form">
			<div class="row">
				<div class="form-group">          
					<label for="alumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar participante:</label>
					<div class="typeahead__container col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<div class="typeahead__field">             
							<span class="typeahead__query">
								<input class="alumnos_typeahead form-control" name="alumno" type="search" placeholder="Nombre, Apellido, Número de documento" autocomplete="off" id="alumno">
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
				<p>Partipantes en el curso.</p>
			</div>
			@if(isset($curso))
			<div class="box-body">
			@else
			<div class="box-body" style="display: none;">
			@endif
				<table class="table table-striped" id="alumnos-del-curso">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Documento</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						@if(isset($curso))
						@foreach($curso->alumnos as $alumno)
						<tr>
							<td>{{$alumno->nombres}}</td>
							<td>{{$alumno->apellidos}}</td>
							<td>{{$alumno->nro_doc}}</td>
							<td>
									<div class="btn btn-xs btn-info"><a href="alumnos/{{$alumno->id_alumno}}"><i class="fa fa-search" data-id="{{$alumno->id_alumno}}"></i></a></div>
									<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>
							</td>
						</tr>
						@endforeach
						@endif
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
				return '<tr><td><a href="alumnos"><i class="fa fa-plus text-green"></i><span>Crear participante</span></a></td></tr>';
			},
			source: {
				Nombres: {
					display: 'apellidos',
					ajax:{
						url: "alumnos/typeahead/apellidos",
						path: "data.info",
						data: {
							q: "@{{query}}"
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
						data: {
							q: "@{{query}}"
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
						data: {
							q: "@{{query}}"
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
					'<div class="btn btn-xs btn-info "><a href="alumnos/'+item.id+'"><i class="fa fa-search" data-id="'+item.id+'"></i></a></div>'+
					'<div class="btn btn-xs btn-danger quitar"><i class="fa fa-minus"></i></div>'+
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
						$('#alumnos-del-curso').closest('div').show();
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