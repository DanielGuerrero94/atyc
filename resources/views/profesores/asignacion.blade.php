<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<form role="form">
			<div class="row">
				<div class="form-group">          
					<label for="profesor" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar docente:</label>
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
				<p>Docentes a cargo del curso - Cantidad: <b><span id="contador-docentes"></span></b></p>
			</div>
			@if(isset($curso))
			<div class="box-body">
				@else
				<div class="box-body" style="display: none;">
					@endif
					<table class="table table-striped" id="profesores-del-curso">
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
							@foreach($curso->profesores as $profesor)
							<tr>
								<td>{{$profesor->nombres}}</td>
								<td>{{$profesor->apellidos}}</td>
								<td>{{$profesor->nro_doc}}</td>
								<td>
									<div class="btn btn-xs btn-info"><a href="{{url('/profesores/'.$profesor->id_profesor)}}"><i class="fa fa-search" data-id="{{$profesor->id_alumno}}"></i></a></div>
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
</div>
@section('script')
<script type="text/javascript">

	$(document).ready(function() {
		//Inicial
		refreshCounter();

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
				return '<tr><td><a href="profesores"><i class="fa fa-plus text-green"></i><span>Crear docente</span></a></td></tr>';
			},
			source: {
				Nombres: {
					display: 'apellidos',
					ajax:{
						url: "{{url('profesores/typeahead')}}",
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
						url: "{{url('profesores/typeahead')}}",
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
						url: "{{url('profesores/typeahead')}}",
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
					'<div class="btn btn-xs btn-info"><a href="profesores/'+item.id+'"><i class="fa fa-search" data-id="'+item.id+'"></i></a></div>'+
					'</span>'+
					'</td>'+
					'</tr>';
					existe = false;
					$.each($('#profesores-del-curso tbody tr .fa-search'),function(k,v){
						if($(v).data('id') == item.id){
							existe = true;
						}
					});

					if(!existe){
						$('#profesores-del-curso tbody').append(profesor);	
						$('#profesores-del-curso').closest('div').show();
						refreshCounter();						
					}
					$('#profesores .profesores_typeahead').val('');
				}
			},
			debug: true
		});

		$('#profesores-del-curso').on('click','.quitar', function(event) {
			this.closest('tr').remove();
			refreshCounter();
		});

		function refreshCounter() {
			let count = $('#profesores-del-curso tbody').children().length;
			$('#contador-docentes').html(count);
		}

	});

</script>
@endsection