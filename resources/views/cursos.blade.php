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

  //Comportamientos de Acciones
	function accionesBehaviour() {
		ejecutarCursoBehaviour();
		reprogramarCursoBehaviour();
		desactivarCursoBehaviour();
	}

	//Comportamiento para Ejecutar Curso
	function ejecutarCursoBehaviour() {
		$('.container-fluid').on("click",".ejecutar_curso", function() {
			var id = $(this).data('id');
			
			jQuery('<div/>', {
				id: 'dialogEjecutar',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogEjecutar").dialog({
				title: "Informar la Ejecución del Curso",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 400,
				height : 300,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					jQuery('<p/>', {
						id: 'dialogEjecutar',
						text: "Seleccionar las fechas de ejecución"
					}).appendTo('#dialogEjecutar');

					jQuery('<p/>', {
						id: 'p_fecha_inicio',
						text: 'Fecha Inicial de Ejecución'
					}).appendTo('#dialogEjecutar');

					jQuery('<input/>', {
						type: "text",
						name: "fecha_ejec_inicial",
						id: "fecha_ejec_inicial",
						class: "form-control pull-right datepicker"
					}).appendTo('#dialogEjecutar');

					jQuery('<p/>', {
						id: 'p_fecha_final',
						text: 'Fecha Final de Ejecución'
					}).appendTo('#dialogEjecutar');

					jQuery('<input/>', {
						type: "text",
						name: "fecha_ejec_final",
						id: "fecha_ejec_final",
						class: "form-control pull-right datepicker"
					}).appendTo('#dialogEjecutar');

					$('.datepicker').datepicker({
						format: 'dd/mm/yyyy',
						language: 'es',
						autoclose: true,
					});
				},
				close: function() {
					removeDialog($(this), 'dialogEjecutar');
				},

				buttons :
				{
				"Aceptar y completar" : function () {
					$.ajax ({
						url: "{{url('cursos')}}" + '/' + id + '/ejecutar',
						method: 'put',
						data: getDataEjecucionCurso(),
						success: function(data){
							console.log(data);
							if(data != "error") {
								console.log("Se informó la ejecución del curso: "+id+" y va a editarlo ahora");
								alert("Se informó la ejecución del curso. Va a completar los alumnos y profesor ahora");
								$('#abm-table').DataTable().clear().draw();
								location.replace("{{url('cursos')}}" + '/' + id);
							}
						},
						error: function (data) {
							console.log('Hubo un error.');
							console.log(data);
						}
					});
					removeDialog($(this), 'dialogEjecutar');
				},

				"Aceptar" : function () {
					$.ajax ({
						url: "{{url('cursos')}}"+'/'+id+'/ejecutar',
						method: 'put',
						data: getDataEjecucionCurso(),
						success: function(data){
							if(data != "error") {
								console.log("Se informó la ejecución del curso: "+id);
								alert("Se informó la ejecución del curso");
								$('#abm-table').DataTable().clear().draw();
							} else {
								console.log(data + ': falta de fecha');
							}
						},
						error: function (data) {
							console.log('Hubo un error.');
							console.log(data);
						}
					});
					removeDialog($(this), 'dialogEjecutar');
				},

				"Cancelar" : function () {
					removeDialog($(this), 'dialogEjecutar');
				}
				}
			});
		});
	}

	//Selecciona los inputs de la Ejecucion de un Curso
	function getDataEjecucionCurso() {
		if($('#fecha_ejec_final').val() === "" || $('#fecha_ejec_inicial').val() === "")
		{
			alert("Debe seleccionar ambas fechas para poder cargar la ejecución del curso");
			return noDateSelectedError();
		}
		
		var data =
		[
		{
			name: '_token',
			value: $('#abm input').first().val()
		},
		{
			name: 'fecha_ejec_inicial',
			value: $('#fecha_ejec_inicial').val()
		},
		{
			name: 'fecha_ejec_final',
			value: $('#fecha_ejec_final').val()
		},
		{
			name: 'fecha_display',
			value: $('#fecha_ejec_inicial').val()
		},
		{
			name: 'id_estado',
			value: estadoEjecucion()
		}
		];

		console.log(data);
		
		return data;
	}

	//Determina si se está ejecutando en este momento(3) o si ya finalizó(4)
	function estadoEjecucion() {

		var initial = moment($('#fecha_ejec_inicial').val(), 'DD/MM/YYYY').format("YYYY-MM-DD");
		var final = moment($('#fecha_ejec_final').val(), 'DD/MM/YYYY').format("YYYY-MM-DD");

		if(moment('YYYY-MM-DD').isBetween(initial, final, undefined, '[]'))
			estado = 3;
		else
			estado = 4;

		return estado;
	}

	//Comportamiento para Reprogramar Curso
	function reprogramarCursoBehaviour() {
		$('.container-fluid').on("click",".reprogramar_curso", function() {
			var id = $(this).data('id');
			
			jQuery('<div/>', {
				id: 'dialogReprogramar',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogReprogramar").dialog({
				title: "Reprogramación del Curso",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 400,
				height : 300,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					jQuery('<p/>', {
						id: 'dialogReprogramar',
						text: "Seleccionar las fechas de reprogramación"
					}).appendTo('#dialogReprogramar');

					jQuery('<p/>', {
						id: 'p_fecha_reprograma_inicial',
						text: 'Fecha Inicial Reprogramada'
					}).appendTo('#dialogReprogramar');

					jQuery('<input/>', {
						type: "text",
						name: "fecha_reprograma_inicial",
						id: "fecha_reprograma_inicial",
						class: "form-control pull-right datepicker"
					}).appendTo('#dialogReprogramar');

					jQuery('<p/>', {
						id: 'p_fecha_final',
						text: 'Fecha Final Reprogramada'
					}).appendTo('#dialogReprogramar');

					jQuery('<input/>', {
						type: "text",
						name: "fecha_reprograma_final",
						id: "fecha_reprograma_final",
						class: "form-control pull-right datepicker"
					}).appendTo('#dialogReprogramar');

					$('.datepicker').datepicker({
						format: 'dd/mm/yyyy',
						language: 'es',
						autoclose: true,
					});
				},
				close: function() {
					removeDialog($(this), 'dialogReprogramar');
				},

				buttons :
				{
				"Aceptar" : function () {
					$.ajax ({
					url: "{{url('cursos')}}"+'/'+id+'/reprogramar',
					method: 'put',
					data: getDataReprogramacionCurso(),
					success: function(data){
						if(data != "error") {
							console.log("Se reprogramó el curso: "+id);
							alert("Se reprogramó el curso");
							$('#abm-table').DataTable().clear().draw();
						} else {
							console.log(data + ': falta de fecha');
						}
					},
					error: function (data) {
						console.log('Hubo un error.');
						console.log(data);
					}
					});
					removeDialog($(this), 'dialogReprogramar');
				},

				"Cancelar" : function () {
					removeDialog($(this), 'dialogReprogramar');
				}
				}
			});
		});
	}

	//Selecciona los inputs de la Reprogramacion de un Curso
	function getDataReprogramacionCurso() {
		if($('#fecha_reprograma_inicial').val() === "" || $('#fecha_reprograma_final').val() === "")
		{
			alert("Debe seleccionar ambas fechas para poder reprogramar el curso");
			return noDateSelectedError();
		}

		var data =
		[
		{
			name: '_token',
			value: $('#abm input').first().val()
		},
		{
			name: 'fecha_plan_inicial',
			value: $('#fecha_reprograma_inicial').val()
		},
		{
			name: 'fecha_plan_final',
			value: $('#fecha_reprograma_final').val()
		},
		{
			name: 'fecha_display',
			value: $('#fecha_reprograma_inicial').val()
		},
		{
			name: 'id_estado',
			value: 5
		}
		];

		console.log(data);
		
		return data;
	}

	//Comportamiento para Desactivar Curso
	function desactivarCursoBehaviour() {
		$('.container-fluid').on("click",".desactivar_curso", function() {
			var id = $(this).data('id');
			
			jQuery('<div/>', {
				id: 'dialogDesactivar',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogDesactivar").dialog({
				title: "Desactivación del Curso",
				show: {
					effect: "fold"
				},
				hide: {
					effect: "fade"
				},
				modal: true,
				width : 400,
				height : 300,
				closeOnEscape: true,
				resizable: false,
				dialogClass: "alert",
				open: function () {
					jQuery('<p/>', {
						id: 'dialogDesactivar',
						text: "¿Está segura/o de desactivar el curso? Desactivarlo no le permitirá realizar el curso en el futuro"
					}).appendTo('#dialogDesactivar');
				},
				close: function() {
					removeDialog($(this), 'dialogDesactivar');
				},
				buttons :
				{
				"Aceptar" : function () {
					$.ajax ({
					url: "{{url('cursos')}}"+'/'+id+'/desactivar',
					method: 'put',
					data: getDataDesactivacionCurso(),
					success: function(data){
						console.log(data);
						alert("Se desactivó el curso");
						$('#abm-table').DataTable().clear().draw();
					},
					error: function (data) {
						console.log('Hubo un error.');
						console.log(data);
					}
					});
					removeDialog($(this), 'dialogDesactivar');
				},

				"Cancelar" : function () {
					removeDialog($(this), 'dialogDesactivar');
				}
				}
			});
		});
	}

	//Selecciona los inputs de la desactivacion de un curso
	function getDataDesactivacionCurso() {
		var data = 
		[
		{
			name: '_token',
			value: $('#abm input').first().val()
		},
		{
			name: 'id_estado',
			value: 6
		}
		];

		console.log(data);

		return data;
	}

	// Abstracciones para el comportamiento de acciones
	// Abstraccion para remover todo lo referido a un dialogo iniciado
	function removeDialog(dialog, id) {
		dialog.dialog("destroy");
		$("#"+id).html("");
		$('.container-fluid #'+id).html("");
		$('.container-fluid #'+id).remove();
		$('[role=dialog]').html("");
		$('[role=dialog]').remove();
	}

	//Abstraccion para cuando no seleccionan una fecha
	function noDateSelectedError() {
		data =  
		[
		{
			name: '_token',
			value: $('#abm input').first().val()
		},
		{
			name: "error",
			value: 0
		}
		];

		console.log(data);
		return data;
	}

	function semaforoEstado(id_estado) {
		var colores = ["#ffc107", "#17a2b8","#1E90FF", "#28a745", "#A9A9A9", "#dc3545"];
		var titulos = ["Planificado", "Diseñado", "En ejecución", "Finalizado", "Reprogramado", "Desactivado"];

		return semaforo( {color: colores[id_estado-1], titulo: titulos[id_estado-1] });
	}

	function semaforo({color, titulo}) {
		return iconFA({icon: "fa-circle", color, titulo})
	}

	function iconFA({icon="fa-bolt", color="#444" , titulo=""}) {
		return '<i class="fa '+icon+' fa-lg" style="color: '+color+';" title="'+titulo+'"> </i>';
	}

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

	function ejecutarCursoButton(id_curso) {
		return '<a href="javascript:void(0)" data-id="'+id_curso+'" class="btn btn-circle ejecutar_curso">' + iconFA({ icon: "fa-check", color: "#1E90FF", titulo: "Informar ejecución" }) + '</a>';
	}

	function reprogramarCursoButton(id_curso) {
		return '<a href="javascript:void(0)" data-id="'+id_curso+'" class="btn btn-circle reprogramar_curso">' + iconFA({ icon: "fa-clock-o", color: "#FFD700", titulo: "Reprogramar" }) + '</a>';
	}

	function desactivarCursoButton(id_curso) {
		return '<a href="javascript:void(0)" data-id="'+id_curso+'" class="btn btn-circle desactivar_curso">' + iconFA({ icon: "fa-ban", color: "#B22222", titulo: "Desactivar" }) + '</a>';
	}

	function cambiarEstadoCursoButtons(id_curso) {
		return ejecutarCursoButton(id_curso) + reprogramarCursoButton(id_curso) + desactivarCursoButton(id_curso);
	}

	function acciones(estado, id_curso, created_at, pac) {
		buttons = seeButton(id_curso) + editButton(id_curso);

		console.log(pac);

		@if(Auth::user()->id_provincia === 25)
			buttons += deleteButton(id_curso);
		@else
		if(createdAtValidDate(created_at))
			buttons += deleteButton(id_curso);
		@endif

		@if(isset($prefilters) && in_array(1, $prefilters))

		if (pac.id_estado == 3 && estado != "Finalizado" && estado != "Desactivado") {
			if (estado != "Planificado") {
				buttons += cambiarEstadoCursoButtons(id_curso);
			} else if (!pac.ficha_obligatoria) {
				buttons += cambiarEstadoCursoButtons(id_curso);
			}
		}
		@endif

		return buttons;
	}

	function createdAtValidDate(created_at) {
		var created_date = moment(created_at);
		var current_date = moment();

		diff = current_date.diff(created_date, 'days');

		return diff <= 7; // se creo la misma semana
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

		console.log(data);
		return data;
	}

	function fechaPlanificada(fecha_inicial, fecha_final) 
	{
		inicial = moment(fecha_inicial).format('DD/MM/YYYY');
		final = moment(fecha_final);

		if(moment().isAfter(final))
			fecha = '<p title="Se pasó fecha de ejecución planificada sin informar" style="color:red;">'+inicial+'</p>';
		else
			fecha = inicial;

		return fecha;		
	}

	function createDatatable() {
		var filtrosJson = getFiltrosJson();

		datatable = $('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax: {
				url: "{{url('cursos/filtrado')}}",
				data: {
					filtros: filtrosJson
				}
			},
			columns: [
			@if(isset($prefilters) && in_array(1, $prefilters))
			{ title: 'Fecha Planificada', data: 'fecha_plan_inicial', defaultContent: '-',
				render: function(data, type, row, meta) {
					return fechaPlanificada(data, row.fecha_plan_final);
				}
			},
			@else
			{ title: 'Fecha', data: 'fecha_display', defaultContent: '-',
				render: function(data) {
					return moment(data).format('DD/MM/YYYY');
				}
			},
			@endif
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
			{ data: 'estado.nombre', name: 'id_estado', width: '20%',
				render: function ( data, type, row, meta ) {
					return acciones(data, row.id_curso, row.created_at, row.pac);
				},
				orderable: false
			}
			],
			responsive: true
		});

		return datatable;
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
						url: "{{url('cursos/nombres')}}",
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

		var prefilters = [];
		@if(isset($prefilters))
			@foreach($prefilters as $prefilter)
				prefilters.push({{$prefilter}});
			@endforeach
			
		@endif
		$('.estados').val(prefilters);
		$('.estados').trigger('change');
		datatable = createDatatable();

		$('.excel').on('click',function () {
			var filtros = getFiltrosJson();
			var order_by = $('#abm-table').DataTable().order();

			$.ajax({
				url: "{{url('cursos/excel')}}",
				data: {
					filtros: filtros,
					order_by: order_by
				},
				beforeSend: function () {
					alert('Se descargara pronto.');
				},
				success: function(data){
					console.log(data);
					window.location="{{url('/descargar/excel/')}}"+"/"+data;
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
				url: "{{url('cursos/pdf')}}",
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
			datatable = createDatatable();
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
							url: "{{url('cursos/')}}"+"/"+curso,
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
				url : "{{url('cursos/')}}"+"/"+curso,
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

		accionesBehaviour();

	});

</script> 
@endsection

