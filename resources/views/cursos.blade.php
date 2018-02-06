@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">	
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('cursos.filtros')		
		</div>
	</div>
	<div class="row">		
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('cursos.abm')
		</div>
	</div>
	<div class="row">
		<div id="alta-accion" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

	function participantesLabel(cantidad) {
		return '<small class="label bg-blue" title="' + cantidad + ' Participantes"><i class="fa fa-users"> ' + cantidad + '</i></small>';
	}

	function editButton(id_curso) {
		return '<a href="{{url("/cursos")}}/' + id_curso + '" data-id="' + id_curso + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_curso) {
		return '<a href="#" data-id="' + id_curso + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
	}

	$(document).ready(function(){

		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});

		datatable = $('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'cursos/tabla',
			columns: [
			{ title: 'Nombre', data: 'nombre'},
			{ title: 'Fecha', data: 'fecha'},
			{ title: 'Edicion', data: 'edicion'},
			{ title: 'Duracion', data: 'duracion'},			
			{ title: 'Tematica', data: 'area_tematica.nombre', name: 'id_area_tematica'},
			{ title: 'Tipologia', data: 'linea_estrategica.nombre', name: 'id_linea_estrategica'},
			{ title: 'Jurisdiccion', data: 'provincia.nombre', name: 'id_provincia'},
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
					return /*participantesLabel(row.alumnos_count) + */editButton(row.id_curso) + deleteButton(row.id_curso);
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
			var provincia = $('#provincia option:selected').data('id');
			var linea_estrategica = $('#linea_estrategica option:selected').data('id');
			var area_tematica = $('#area_tematica option:selected').data('id');
			var periodo = $('#periodo option:selected').data('id');
			var desde = $('#desde').val();
			var hasta = $('#hasta').val();			

			return data = {
				nombre: nombre,
				duracion: duracion,
				edicion: edicion,
				id_provincia: provincia,
				id_linea_estrategica: linea_estrategica,
				id_area_tematica: area_tematica,
				id_periodo: periodo,
				desde: desde,
				hasta: hasta
			};
		};

		$('.excel').on('click',function () {
			var filtros = getFiltrosJson();
			var order_by = $('#abm-table').DataTable().order();
			console.log(filtros);
			console.log(order_by);

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
			console.log(filtrosJson);

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
				{ title: 'Nombre', data: 'nombre'},
				{ title: 'Fecha', data: 'fecha'},
				{ title: 'Edicion', data: 'edicion'},
				{ title: 'Duracion', data: 'duracion'},			
				{ title: 'Tematica', data: 'area_tematica.nombre', name: 'id_area_tematica'},
				{ title: 'Tipologia', data: 'linea_estrategica.nombre', name: 'id_linea_estrategica'},
				{ title: 'Jurisdiccion', data: 'provincia.nombre', name: 'id_provincia'},
				{ 
					data: 'acciones',
					render: function ( data, type, row, meta ) {
						return participantesLabel(row.alumnos_count) + editButton(row.id_curso) + deleteButton(row.id_curso);
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
			$('#abm').removeClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('#abm').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
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
						text: '¿Esta seguro que quiere dar de baja al profesor?'
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

