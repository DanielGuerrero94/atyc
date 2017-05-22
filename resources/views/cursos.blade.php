@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros">
		@include('cursos.filtros')
	</div>	
	<div id="abm">
		@include('cursos.abm')			
	</div>
	<div id="alta" style="display: none;"></div>				
</div>
@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});

		$('#abm-table').DataTable({
			destroy: true,
			ajax : 'cursos/tabla',
			columns: [
			{ data: 'nombre'},
			{ data: 'fecha'},
			{ data: 'edicion'},
			{ data: 'duracion'},
			{ data: 'area_tematica.nombre'},
			{ data: 'linea_estrategica.nombre'},
			{ data: 'provincia.nombre'},
			{ data: 'acciones'}
			]
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
			console.log(filtros);
			var order_by = $('#abm-table').DataTable().order();
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

			$('#abm-table').DataTable({
				destroy: true,
				ajax: {
					url: 'cursos/filtrado',
					data: {
						filtros: filtrosJson 
					}
				},
				columns: [
				{ data: 'nombre'},
				{ data: 'fecha'},
				{ data: 'edicion'},
				{ data: 'duracion'},
				{ data: 'area_tematica.nombre'},
				{ data: 'linea_estrategica.nombre'},
				{ data: 'provincia.nombre'},
				{ data: 'acciones'}
				]
			});
		});

		$('#alta_curso').on("click",function(){

			$.ajax({
				url: 'cursos/alta',
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#filtros').hide();
					$('#abm').hide();
				}
			});
		});

		/*$('#abm').on("click",".editar",function(){
			var curso = $(this).data('id');
			console.log(curso);
			$('#filtros').hide();
			$('#abm').hide();
			$.ajax({
				url: 'cursos/'+curso,
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				}
			})
		});*/

		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear el curso.');
			$('#alta').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		/*$("#alta").on("click","#modificar",function(){

			var curso = $(this).data('id');
			var data = $('#alta form').serialize();
			data += '&id_area_tematica='+$('#alta form #area_tematica :selected').data('id');
			data += '&id_linea_estrategica='+$('#alta form #linea_estrategica :selected').data('id');
			data += '&id_provincia='+$('#alta form #provincia :selected').data('id');


			console.log(data);

			$.ajax({
				url: 'cursos/'+curso,
				method: 'put',
				data: data,
				success: function(data){
					console.log('Se modifico el curso correctamente.');
					$('#alta').html("");
					$('#abm').show();
					$('#filtros').show();
				},
				error: function (data) {
					console.log('Hubo un error.');
					console.log(data);
				}
			})


		});	*/

		$('#abm').on('click','.expand',function () {
			$('.container').addClass('col-md-12');
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('.container').removeClass('col-md-12');
			$('.expand').show();	
			$(this).hide();	
		});

		$('#abm').on("click",".eliminar",function(){
			var curso = $(this).data('id');
			var data = '_token='+$('#abm input').first().val();
			jQuery('<div/>', {
				id: 'dialogABM',
				text: ''
			}).appendTo('.container');

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

		$('#alta').on('click','#modificar',function() {

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

