@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">	
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('cursos.filtros')		
		</div>
	</div>
	<div class="row">		
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('cursos.abm')
		</div>
	</div>
	<div class="row">
		<div id="alta-accion" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"}}"></script>
<script type="text/javascript">

	function participantesLabel(cantidad) {
		return '<small class="label bg-blue" title="' + cantidad + ' Participantes"><i class="fa fa-users"> ' + cantidad + '</i></small>';
    }

    function seeButton(id_curso) {
	    return '<a href="{{url("/cursos")}}/' + id_curso + '/see" data-id="' + id_curso + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}

	function editButton(id_curso) {
		return '<a href="{{url("/cursos")}}/' + id_curso + '" data-id="' + id_curso + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_curso) {
		return '<a href="#" data-id="' + id_curso + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
	}

	function acciones(id_curso, created_at) {
		buttons = seeButton(id_curso) + editButton(id_curso);

		@if(Auth::user()->id_provincia === 25)
			buttons += deleteButton(id_curso);
		@else
		if(createdAtValidDate(created_at))
			buttons += deleteButton(id_curso);
		@endif

		return buttons;
	}

	function createdAtValidDate(created_at) {
		var created_date = moment(created_at);
		var current_date = moment();

		diff = current_date.diff(created_date, 'days');

		return diff <= 7; // se creo la misma semana
	}

	function semaforoEstado(id_estado) {

		var colores = ["#ffc107", "#17a2b8","#1E90FF", "#28a745", "#A9A9A9", "#dc3545"];
		var titulos = ["Planificado", "Diseñado", "En ejecución", "Finalizado", "Reprogramado", "Desactivado"];

		return semaforo( {color: colores[id_estado-1], titulo: titulos[id_estado-1] });
	}

	function semaforo({color, titulo}) {
		return iconFA({icono: "fa-circle", color, titulo})
	}

	function iconFA({icono="fa-bolt", color="#444" , titulo=""}) {
		return '<i class="fa '+icono+' fa-lg" style="color: '+color+';" title="'+titulo+'"> </i>';
	}

	function inicializarSelect2() {
		$('.provincias').select2({
			"placeholder": {
				id: '0',
				text: " Todas las provincias"
			},
			width : "400%"
		});

		$('.lineas_estrategicas').select2({
			"placeholder": {
				id: '0',
				text: " Todos los tipos de acción"
			},
			width : "400%"
		});

		$('.tematicas').select2({
			"placeholder": {
				id: '0',
				text: " Todas las temáticas"
			},
			width : "400%"
		});

		$('.estados').select2({
			"placeholder": {
				id: '0',
				text: " Todos los estados"
			},
			width : "400%"
		});

		$('.periodos').select2({
			"placeholder": "Todos los periodos",
			width: "400%"
		});

		$('.select-2').ready(function() {
        	$('.select2-container--default .select2-selection--multiple').css('height', 'auto');
			$('#filtros .box').toggle();
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
      	});

		$('.select-2').on('select2:select', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});

		$('.select-2').on('select2:unselect', function () {
			$('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
		});
	}

	$(document).ready(function(){

		inicializarSelect2();
		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').toggle();

			$.typeahead({
				input: '.curso_filtro_typeahead',
				order: "desc",
				source: {
					info: {
					ajax: {
						type: "get",
						url: "cursos/nombres",
						path: "data.info"
					}
					}
				},
				callback: {
					onInit: function (node) {
					console.log('Typeahead Initiated on ' + node.selector);
					}
				}
			});
		});

		datatable = $('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'cursos/tabla',
			columns: [
			{ title: 'Fecha', data: 'fecha_display', defaultContent: '-',
				render:function(data){
					return moment(data).format('DD/MM/YYYY');
				}
			},
			{ title: 'Nombre', data: 'nombre'},
			{ title: 'Estado', data: 'id_estado', defaultContent: '-', 
				render: function (data, type, row, meta) {
					return semaforoEstado(data);
				}
			},
			{ title: 'Edicion', data: 'edicion'},
			{ title: 'Duracion', data: 'duracion'},			
			{ title: 'Tematica/s', data: 'areas_tematicas', name: 'id_area_tematica', defaultContent: '-',
				render: function ( data, type, row, meta) {
					return data.map(function(tematica) {return ' ' + tematica.nombre; });
				},
				orderable: false
			},
			{ title: 'Tipologia', data: 'linea_estrategica', name: 'id_linea_estrategica', defaultContent: '-',
				render: function (data, type, row, meta) {
					return data.numero + " " + data.nombre;
				}
			},
			{ title: 'Jurisdiccion', data: 'provincia.nombre', name: 'id_provincia'},
			{ data: 'id_curso',
				render: function ( data, type, row, meta ) {
					//return /*participantesLabel(row.alumnos_count) + */
					return acciones(data, row.created_at);
					// return data;
				},
				orderable: false
			}
			],
			responsive: true
		});

		function getFiltrosJson() {

			var nombre = $('#nombre').val();
			var duracion = $('#duracion').val();
			var edicion = $('#edicion').val();
			var provincias = $('#provincias').val();
			var lineas_estrategicas = $('#lineas_estrategicas').val();
			var areas_tematicas = $('#tematicas').val();
			var estados = $('#estados').val();
			var periodo = $('#periodo option:selected').data('id');
			var desde = $('#desde').val();
			var hasta = $('#hasta').val();			

			data = {
				nombre: nombre,
				duracion: duracion,
				edicion: edicion,
				id_provincia: provincias,
				id_linea_estrategica: lineas_estrategicas,
				id_area_tematica: areas_tematicas,
				id_estado: estados,
				id_periodo: periodo,
				desde: desde,
				hasta: hasta
			};

			return data;
		};

		$('.excel').on('click',function () {
			var filtros = getFiltrosJson();
			var order_by = $('#abm-table').DataTable().order();

			$.ajax({
				url: 'cursos/excel',
				data: {
					filtros: filtros,
					order_by: order_by
				},
				beforeSend: function () {
					alert('Se descargara pronto.');
				},
				success: function(data){
					console.log(data);
					window.location="descargar/excel/"+data;
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
					console.log(data);
				}
			});
		});

		$('.pdf').on('click',function () {
			var filtros = getFiltrosJson();
			console.log(filtros);
			var order_by = $('#abm-table').DataTable().order();
			console.log(order_by);			

			$.ajax({
				url: 'cursos/pdf',
				data: {
					filtros: filtros,
					order_by: order_by				
				},
				beforeSend: function() {
					alert('Se descargara pronto.');
				},
				success: function(data){
					console.log(data);
					window.location="descargar/pdf/"+data;
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
					console.log(data);
				}
			});			
		});

		$('#filtros').on('click','#filtrar',function () {
			var filtrosJson = getFiltrosJson();

			datatable = $('#abm-table').DataTable({
				destroy: true,
				searching: false,
				ajax: {
					url: 'cursos/filtrado',
					data: {
						filtros: filtrosJson 
					}
				},
				columns: [
				{ title: 'Fecha', data: 'fecha_display', defaultContent: '-',
					render: function(data) {
						return moment(data).format('DD/MM/YYYY');
					}
				},
				{ title: 'Nombre', data: 'nombre'},
				{ title: 'Estado', data: 'id_estado', defaultContent: '-',
					render: function (data, type, row, meta) {
						return semaforoEstado(data);
					}
				},				
				{ title: 'Edicion', data: 'edicion'},
				{ title: 'Duracion', data: 'duracion'},	
				{ title: 'Tematica/s', data: 'areas_tematicas', name: 'id_area_tematica', defaultContent: '-',
					render: function ( data, type, row, meta) {
						return data.map(function(tematica) {return ' ' + tematica.nombre; });
					},
					orderable: false
				},
				{ title: 'Tipologia', data: 'linea_estrategica', name: 'id_linea_estrategica', defaultContent: '-',
					render: function (data, type, row, meta) {
						return data.numero + " " + data.nombre;
					}
				},
				{ title: 'Jurisdiccion', data: 'provincia.nombre', name: 'id_provincia'},
				{ data: 'id_curso',
					render: function ( data, type, row, meta ) {
						//return /*participantesLabel(row.alumnos_count) + */
						return acciones(data, row.created_at);
						// return data;
					},
					orderable: false
				}
				],
				responsive: true
			});	

		});

		$('#alta_curso').on("click",function(){

			$.ajax({
				url: "{{url('cursos/alta')}}",
				method: 'get',
				success: function(data){
					$('#alta-accion').html(data);
					$('#alta-accion').show();
					$('#filtros').hide();
					$('#abm').hide();
				}
			});
		});

		$("#alta-accion").on("click","#volver",function(){
			console.log('Se vuelve sin crear el curso.');
			$('#alta-accion').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		$('#abm').on('click','.expand',function () {
			$('#abm').removeClass("col-xs-10 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1");
			$('#abm').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-12");
			datatable.draw();
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('#abm').removeClass("col-xs-12 col-sm-12 col-md-12 col-lg-12");
			$('#abm').addClass("col-xs-10 col-sm-10 col-md-10 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.expand').show();
			$(this).hide();	
		});

		$('#abm').on("click",".eliminar",function(){
			var curso = $(this).data('id');
			var data = '_token='+$('#abm input').first().val();
			jQuery('<div/>', {
				id: 'dialogABM',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogABM").dialog({
				title: "Verificacion",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 360,
				height : 220,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					jQuery('<p/>', {
						id: 'dialogABM',
						text: '¿Esta seguro que quiere dar de baja al curso?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						$.ajax ({
							url: 'cursos/'+curso,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro el curso.');
								location.reload();
							},
							error: function (data) {
								console.log('Hubo un error.');
								console.log(data);
							}
						});

					},
					"Cancelar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						location.reload("true");
					}
				}
			});
		});

		$('#alta-accion').on('click','#modificar',function() {

			var curso = $(this).data('id');

			$.ajax({				
				url : 'cursos/'+curso,
				method : 'put',
				data : $('form').serialize(),
				success : function(data){
					console.log("Success.");
					location.reload();	
				},
				error : function(data){
					console.log("Error.");
				}
			});
		});

	});

</script> 
@endsection

