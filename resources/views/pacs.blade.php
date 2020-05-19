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

		diff = created_date.diff(current_date, 'days');

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

	function uploadFichaButton(id_pac) {
		return '<a href="#abm" data-id="' + id_pac + '" class="btn btn-circle upload-ficha_tecnica" title="Subir"><i class="fa fa-upload fa-lg" style="color: #228B22;"> </i> </a> ';
	}

	function updateFichaButton(id_ficha) {
		return '<a href="#abm" data-id="'+ id_ficha + '" class="btn btn-circle update-ficha_tecnica" title="Reemplazar"><i class="fa fa-cloud-upload fa-lg text-primary"> </i> </a> ';
	}

	function downloadFichaButton(id_ficha) {
		return '<a href="{{url("/pacs/ficha_tecnica")}}/' + id_ficha + '/download" data-id="'+ id_ficha + '" class="btn btn-circle download-ficha_tecnica" title="Descargar"><i class="fa fa-download fa-lg" style="color: #2F2D2D;"></i></a>';
	}

	function aprobarFichaButton(id_ficha) {
		return '<a href="#abm" data-id="' + id_ficha + '" class="btn btn-circle aprobar-ficha_tecnica" title="Aprobar"><i class="fa fa-check fa-lg" style="color: #1E90FF;"></i></a>';
	}
	
	@if(Auth::user()->id_provincia === 25)
	function fichaTecnicaButtons(ficha, id_pac) {
		if(jQuery.isEmptyObject(ficha)) {
			return '<i class="fa fa-circle fa-lg" style="color: #B22222;" title="No tiene"> </i>' + uploadFichaButton(id_pac);
		} else if (!ficha.aprobada) {
			return '<i class="fa fa-circle fa-lg" style="color: #FFD700;" title="En diseño"> </i>' + aprobarFichaButton(ficha.id_ficha_tecnica) + updateFichaButton(ficha.id_ficha_tecnica) + downloadFichaButton(ficha.id_ficha_tecnica);
		} else {
			return '<i class="fa fa-circle fa-lg" style="color: #228B22;" title="Aprobada"> </i>' + updateFichaButton(ficha.id_ficha_tecnica) + downloadFichaButton(ficha.id_ficha_tecnica);
		}
	}
	@else
	function fichaTecnicaButtons(ficha, id_pac) {
		if(jQuery.isEmptyObject(ficha)) {
			return '<i class="fa fa-circle fa-lg" style="color: #B22222;" title="No tiene"> </i>' + uploadFichaButton(id_pac);
		} else if (!ficha.aprobada) {
			return '<i class="fa fa-circle fa-lg" style="color: #FFD700;" title="En diseño"> </i>' + updateFichaButton(ficha.id_ficha_tecnica) + downloadFichaButton(ficha.id_ficha_tecnica);
		} else {
			return '<i class="fa fa-circle fa-lg" style="color: #228B22;" title="Aprobada"> </i>' + downloadFichaButton(ficha.id_ficha_tecnica);
		}
	}
	@endif

	function getFiltrosJson() {

		var anios = $('#anios').val();
		var provincias = $('#provincias').val();
		var nombre = $('#nombre').val();
		var duracion = $('#duracion').val();
		var ediciones = $('#edicion').val();
		var estados_ficha = $('#estados_ficha').val();
		var tipos_accion = $('#acciones').val();
		var tematicas = $('#tematicas').val();
		var destinatarios = $('#destinatarios').val();
		var responsables = $('#responsables').val();
		var pautas = $('#pautas').val();
		var componentes = $('#componentes').val();
		

		// var provincia = $('#provincia option:selected').data('id');
		// var linea_estrategica = $('#linea_estrategica option:selected').data('id');
		// var area_tematica = $('#area_tematica option:selected').data('id');
		// var periodo = $('#periodo option:selected').data('id');
		// var desde = $('#desde').val();
		// var hasta = $('#hasta').val();			

		data = {
			anio: anios,
			id_provincia: provincias,
			nombre: nombre,
			duracion: duracion,
			ediciones: ediciones,
			ficha_tecnica_aprobada: estados_ficha,
			id_accion: tipos_accion,
			id_tematica: tematicas,
			id_destinatario: destinatarios,
			id_responsable: responsables,
			id_pauta: pautas,
			id_componente: componentes
			// id_periodo: periodo,
			// desde: desde,
			// hasta: hasta
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

		$('.estados_ficha').select2({
			"placeholder": {
				id: '0',
				text: " Todas las fichas"
			},
			width: "400"
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

		$('.select-2').ready(function() {
        	$('.select2-container--default .select2-selection--multiple').css('height', 'auto');
			$('#filtros .box').toggle();
      	});
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
				{
					title: 'Fecha', 
					data: 'created_at',
					defaultContent: '-',
					render:function(data){
						return moment(data).format('DD/MM/YYYY');
					}
				},
				{ title: 'Nombre', data: 'nombre'},
				{ title: 'Ediciones', data: 'ediciones'},
				{ title: 'Duracion', data: 'duracion'},
				{
					title: 'Ficha Técnica',
					data: 'ficha_tecnica',
					name: 'id_ficha_tecnica',
					render: function ( data, type, row, meta ) {
						return fichaTecnicaButtons(data, row.id_pac);
					}
				},
				{ title: 'Jurisdiccion', data: 'provincias.nombre', name: 'id_provincia'},
				{ title: 'Tematica/s', data: 'tematicas', defaultContent: '-', name: 'id_tematica',
					render: function ( data, type, row, meta)
					{
						if(Object.entries(data).length != 0)
							return data.map(function(tematica) { return ' ' + tematica.nombre; });
					},
					orderable: false
				},
				{ title: 'Tipo de Accion', data: 'tipo_accion', name: 'id_linea_estrategica',
					render: function (data, type, row, meta) {
						if(data)
							return data.numero + " " + data.nombre;
						else
							return '-';
					},
					orderable: false
				},
				{ title: "Responsables", data:"responsables", defaultContent: '-', name: 'id_responsable', 
					render: function ( data, type, row, meta)
					{
						if(Object.entries(data).length != 0)
							return data.map(function(responsable) { return ' ' + responsable.nombre; });
					},
					orderable: false
				},
	//			{ title: 'Estados' },
				{ 
					data: 'acciones',
					render: function ( data, type, row, meta ) {
						return tableButtons(row.id_pac, row.created_at);
					},
					orderable: false
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
			$('#alta-pac').html("");
			$('#prefilter').show();
			$('#abm').show();
			$('#filtros').show();
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

		$(".container-fluid").on("click", ".upload-ficha_tecnica", function(event) {
			$(formUpload).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#upload-ficha_tecnica input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
			for (var pair of data.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }
			id_pac = form.parent().find(".upload-ficha_tecnica").data("id");
			$.ajax({
				url: "{{url('pacs')}}" + "/" + id_pac,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al subir el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", ".update-ficha_tecnica", function(event) {
			$(formUpdate).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#update-ficha_tecnica input", function(event) {
			form = $("#update-ficha_tecnica");
			data = new FormData(form[0]);
			id_ficha = form.parent().find(".update-ficha_tecnica").data("id");			
            for (var pair of data.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }
			$.ajax({
				url: "{{url('pacs/fichas_tecnicas')}}" + "/" + id_ficha,
				type: 'post',
				data: data,
				processData: false,
                contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", '.download-ficha_tecnica', function(event) {
			event.preventDefault();
			let id = $(this).data("id");
			location.href = "{{url('/pacs/fichas_tecnicas')}}" + "/" + id + "/download";
		});

		$('#abm').on("click",".aprobar-ficha_tecnica",function(){
			var id_ficha = $(this).data('id');
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
						text: '¿Esta seguro de aprobar la ficha tecnica?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						$.ajax ({
							url: 'pacs/fichas_tecnicas/' +id_ficha+'/aprobar',
							method: 'post',
							data: data,
							success: function(data){
								console.log('Se aprobo la ficha tecnica.');
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
			console.log(filtros);
			console.log(order_by);

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



	// function fichaTecnica(id_pac) {
	// 	if(id_pac->)
	// 	return '<a href="{{url("/pacs/fichas_tecnicas")}}/' + id_pac '" class =
	// }

		
	// function getFiltros(){
	// 		filtros = $('#form-filtros :input')
	// 		.filter(function(i,e){return $(e).val() != "" || $(e).val() != "0"})
	// 		.serializeArray()
	// 		.map(function(obj) { 
	// 			var r = {};
	// 			r[obj.name] = obj.value;
	// 			return r;
	// 		});

	// 		return filtros;
	// 	}

</script> 
@endsection
