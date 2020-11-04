@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="callout callout-info">
			<h2>Planificación Anual de Capacitaciones</h2>
		</div>
	</div>
	<div class="row">
		<div id="prefilter" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('pacs.prefilter')
		</div>
	</div>
	<div class="row">
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('pacs.filtros')
		</div>
	</div>
	<div class="row">
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@include('pacs.abm')
		</div>
	</div>
	<div class="row">
		<div id="alta-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{"//cdn.datatables.net/plug-ins/1.10.20/dataRender/datetime.js"}}"></script>
<script type="text/javascript" src="{{"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"}}"></script>

<script type="text/javascript">

	function createdAtValidDate(created_at) {
		var created_date = moment(created_at);
		var current_date = moment();

		diff = current_date.diff(created_date, 'days');

		return diff <= 7; // se creo la misma semana
	}

	@if(Auth::user()->id_provincia === 25)
	function tableButtons(data, created_at) {
		return seeButton(data) + editButton(data) + deleteButton(data);
	}
	@else
	function tableButtons(data, created_at) {
		if(createdAtValidDate(created_at))
			return seeButton(data) + editButton(data) + deleteButton(data);
		else
			return seeButton(data) + editButton(data);
	}
	@endif

    function seeButton(id_pac) {
	    return '<a href="{{url("/pacs")}}/' + id_pac + '/see" data-id="' + id_pac + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}

	function editButton(id_pac) {
		return '<a href="{{url("/pacs")}}/' + id_pac + '/edit" data-id="' + id_pac + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_pac) {
			return '<a href="#abm" data-id="' + id_pac + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
	}
	
	function iconoFontAwesome({icono="fa-bolt", color="#444" , titulo=""}) {
		return '<i class="fa '+icono+' fa-lg" style="color: '+color+';" title="'+titulo+'"> </i>';
	}
	
	function semaforo({color, titulo}) {
		return iconoFontAwesome({icono: "fa-circle", color, titulo})
	}

	function estadosFicha(ficha, ficha_obligatoria) {
		iconos = '';
		if(!ficha_obligatoria)
			iconos += iconoFontAwesome({icono: "fa-exclamation-triangle", color: "#D3D3D3", titulo: "Optativa"});
		else
			iconos += iconoFontAwesome({icono: "fa-exclamation-triangle", color: "#1E90FF", titulo: "Obligatoria"});
		
		iconos += '  ';

		if(jQuery.isEmptyObject(ficha))
			iconos += semaforo({color: "#B22222", titulo: 'No tiene'});
		else if (!ficha.aprobada)
			iconos += semaforo({color: "#FFD700", titulo: 'En diseño'});
		else
			iconos += semaforo({color: "#228B22", titulo: 'Aprobada'});

		return iconos;
  	}

	function sacarObligatoriedadFichas(value) {
		return (value !== "obligatoria" && value !== "optativa");
	}

	function sacarEstadosFichas(value) {
		return (value == "obligatoria" || value == "optativa");
	}

	function convertirObligatoriedadABool(value) {
		if (value == "obligatoria")
			return true;
		else
			return false; 
	}

	function getFiltrosJson() {

		var anios = $('#anios').val();
		var provincias = $('#provincias').val();
		var nombre = $('#nombre').val();
		var duracion = $('#duracion').val();
		var ediciones = $('#edicion').val();

		var estados_planificacion = $('#estados_planificacion').val();
		var estados_ficha = $('#estados_ficha').val();
		if(!jQuery.isEmptyObject(estados_ficha))
			estados_ficha = estados_ficha.filter(sacarObligatoriedadFichas);
		
		var obligatorios = $('#estados_ficha').val();
		if(!jQuery.isEmptyObject(obligatorios))
			obligatorios = obligatorios.filter(sacarEstadosFichas).map(convertirObligatoriedadABool);

		var tipos_accion = $('#acciones').val();
		var tematicas = $('#tematicas').val();
		var estados_cursos = $('#estados_cursos').val();
		var destinatarios = $('#form-filtros #destinatarios').val()
		var responsables = $('#responsables').val();
		var pautas = $('#pautas').val();
		var componentes = $('#componentes').val();
		var id_periodo = $('#periodo').val();
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();

		data = {
			anio: anios,
			id_provincia: provincias,
			nombre: nombre,
			duracion: duracion,
			ediciones: ediciones,
			id_estado: estados_planificacion,
			ficha_tecnica_aprobada: estados_ficha,
			ficha_obligatoria: obligatorios,
			id_accion: tipos_accion,
			id_tematica: tematicas,
			id_estado_curso: estados_cursos,
			id_destinatario: destinatarios,
			id_responsable: responsables,
			id_pauta: pautas,
			id_componente: componentes,
			periodo: id_periodo,
			desde: desde,
			hasta: hasta
		};

		console.log(data);
		return data;
	}

	function inicializarSelect2()
	{
		$('.provincias').select2({
			"placeholder": {
				id: '0',
				text: " Todas las provincias"
			},
			width : "200%"
		});

		$('.anios').select2({
			"placeholder": {
				id: '0',
				text: " Todos los años"
			},
			width : "200%"
		});

		$('.estados_planificacion').select2({
			"placeholder": {
				id: '0',
				text: " Todos los estados"
			},
			width: "400%"
		});

		$('.estados_ficha').select2({
			"placeholder": {
				id: '0',
				text: " Todas las fichas"
			},
			width: "400%"
		});

		$('.acciones').select2({
			"placeholder": {
				id: '0',
				text: " Todos los tipos de acción"
			},
			width: "400%"
		});

		$('.tematicas').select2({
			"placeholder": {
				id: '0',
				text: " Todas las tematicas"
			},
			width: "400%"
		});

		$('.estados_cursos').select2({
			"placeholder": {
				id: '0',
				text: " Todos los estados"
			},
			width: "400%"
		});

		$('.destinatarios').select2({
			"placeholder": {
				id: '0',
				text: " Todos los destinatarios"
			},
			width: "400%"
		});

		$('.responsables').select2({
			"placeholder": {
				id: '0',
				text: " Todos los responsables"
			},
			width: "400%"
		});

		$('.pautas').select2({
			"placeholder": {
				id: '0',
				text: " Todas las pautas"
			},
			width: "400%"
		});

		$('.componentes').select2({
			"placeholder": {
				id: '0',
				text: " Todos los componentes"
			},
			width: "400%"
		});

		$('.periodo').select2({
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

	function renderProgressPorcentaje (anterior, keyValue) {
		cantidad = keyValue[1]['cantidad'];
		porcentaje = keyValue[1]['porcentaje'];
		color = keyValue[1]['color'];
		titulo = keyValue[1]['titulo'];

		if(cantidad > 1 && titulo != "En ejecución")
			titulo += 's';

		return anterior +
		'<div class="progress-bar '+color+'" role="progressbar" title="'+cantidad+' '+titulo+'" style="width: '+porcentaje+'%;">'+
			''+cantidad+''+
		'</div>';
	}

	function progressBar(estados) {
		progress_bar = '<div class="progress" style="height: 2rem;">';

		progress_bar += estados.reduce(renderProgressPorcentaje, '');

		progress_bar += '</div>';

		return progress_bar;
	}

	function estadosPac(estado) {
		if (estado == null) {
			return iconoFontAwesome({icono: 'fa-question', color: '#6C757D', titulo: 'No tiene estado'});
		}

		switch(estado.id_estado) {
			case 1:
				return iconoFontAwesome({icono: 'fa-minus-square', color: '#FFC107', titulo: estado.nombre});
			case 2:
				return iconoFontAwesome({icono: 'fa-check-square', color: '#28A745', titulo: estado.nombre});
			case 3:
				return iconoFontAwesome({icono: 'fa-window-close', color: '#DC3545', titulo: estado.nombre});
			default:
				return iconoFontAwesome({icono: 'fa-question', color: '#6C757D', titulo: estado.nombre + ' - Estado desconocido'});
		}
	}

	function concatenateMany(data) {
		var concatenated = '';
		for (var i in data) {
			var r = data[i];
			concatenated = concatenated + r.nombre + ', ';
		}
		return concatenated.slice(0, concatenated.length-2);
	}

	$(document).ready(function(){
		
		inicializarSelect2();
		
		formUpload = '<form id="upload-ficha_tecnica" name="upload-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

		formUpdate = '<form id="update-ficha_tecnica" name="update-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';
		
		$('#pac-refresh, #filtrar').click(function () {
			$('#abm .box').show();

			datatable = $('#abm-table').DataTable({
				destroy: true,
				searching: false,
				ajax : {
						url: 'pacs/tabla',
						data: {
							filtros: getFiltrosJson()
						}
				},
				columns: [
				{ title: 'Fecha de Carga', data: 'created_at', defaultContent: '-',
					render: function(data) {
						return moment(data).format('DD/MM/YYYY');
					}
				},
				{ title: 'Fecha Próxima Ejecución', data: 'display_date', defaultContent: '-',
					render: function(data) {
						return moment(data).format('DD/MM/YYYY');
					}
				},
				{ title: 'Estado', data: 'estado', name:'id_estado', defaultContent: '-',
					render: function(data) {
						return estadosPac(data);
					}
				},
				{ title: 'Tipo de Accion', data: 'tipo_accion', name: 'id_linea_estrategica', defaultContent: '-',
					render: function (data, type, row, meta) {
						if(data)
							return data.numero + " " + data.nombre;
					},
					orderable: false
				},
				{ title: 'Nombre', data: 'nombre', width: '10%'},
				{ title: 'Ediciones', data: 'ediciones'},
				{ title: 'Duracion (hs)', data: 'duracion'},
				{
					title: 'Ficha Técnica',
					data: 'ficha_tecnica',
					name: 'id_ficha_tecnica',
					render: function ( data, type, row, meta ) {
						return estadosFicha(data, row.ficha_obligatoria);
					}
				},
				{ title: 'Jurisdiccion - Dependencia Jerárquica', data: 'provincias.nombre', name: 'id_provincia'},
				{ title: 'Tematica/s', defaultContent: '-', name: 'id_tematica',
					render: function ( data, type, row, meta)
					{
						return concatenateMany(row.tematicas);
					},
					orderable: false, width: '20%'
				},
				{ title: "Responsables", defaultContent: '-', name: 'id_responsable', 
					render: function ( data, type, row, meta)
					{
						return concatenateMany(row.responsables);
					},
					orderable: false
				},
				{ title: 'Progreso', data: 'estados_por_curso', 
					render: function(data, type, row, meta) {
						return progressBar(Object.entries(data));
					},
					orderable: false,
					width: '20%'
				},
				{ 
					data: 'acciones',
					render: function ( data, type, row, meta ) {
						return tableButtons(row.id_pac, row.created_at);
					},
					orderable: false,
					width: '15%'
				}
				],
				responsive: true
			});
		});

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


		$('#altas_pac').on("click",function(){

			$.ajax({
				url: "{{url('pacs/alta')}}",
				method: 'get',
				success: function(data){
					$('#alta-pac').html(data);
					$('#alta-pac').show();
					$('#filtros').hide();
					$('#abm').hide();
					$('#prefilter').hide();
				},
				error: function(data){
					console.log(data);
					alert("No se pudo cargar la view de alta de PAC");
				}
			});
		});

		$("#alta-pac").on("click","#volver",function(){
			console.log('Se vuelve sin crear la PAC.');
			location.reload('pacs');
		});

		$('#alta-pac').on('click','#modificar',function() {

			var pac = $(this).data('id');

			$.ajax({				
				url : 'pacs/'+pac,
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

		$('#abm').on("click",".eliminar",function(){
			var pac = $(this).data('id');
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
						text: '¿Esta seguro que quiere dar de baja la pac?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						$.ajax ({
							url: 'pacs/'+pac,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro la pac.');
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

		$('.excel').on('click',function () {
			var filtros = getFiltrosJson();
			var order_by = $('#abm-table').DataTable().order();

			$.ajax({
				url: 'pacs/excel',
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
		
	});

</script>
@endsection
