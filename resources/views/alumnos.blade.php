@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros">
		@include('alumnos.filtros')
	</div>
	<div id="abm">
		@include('alumnos.abm')
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
			ajax : 'alumnos/tabla',
			columns: [
			{ data: 'nombres'},
			{ data: 'apellidos'},
			{ data: 'tipo_documento.nombre'},
			{ data: 'nro_doc'},
			{ data: 'provincia.nombre'},
			{ data: 'acciones'}
			]
		});

		function getFiltrosJson() {
			var nombres = $('#nombres')	.val();
			var apellidos = $('#apellidos').val();
			var id_tipo_documento = $('#id_tipo_documento option:selected').data('id');
			var nro_doc = $('#nro_doc').val();
			var email = $('#email').val();
			var cel = $('#cel').val();
			var tel = $('#tel').val();
			var localidad = $('#localidad').val();
			var id_provincia = $('#provincia option:selected').data('id');

			return data = {
				nombres: nombres,
				apellidos: apellidos,
				id_tipo_documento: id_tipo_documento,
				nro_doc: nro_doc,
				email: email,
				cel: cel,
				tel: tel,
				localidad: localidad,
				id_provincia: id_provincia
			};
		};

		$('#filtros').on('click','#filtrar',function () {

			var filtros = getFiltrosJson();
			console.log(filtros);
			var order_by = $('#abm-table').DataTable().order();
			console.log(order_by);

			$('#abm-table').DataTable({
				destroy: true,
				ajax: {
					url: 'alumnos/filtrado',
					data: {
						filtros: filtros,
						order_by: order_by 
					}
				},
				columns: [
				{ data: 'nombres'},
				{ data: 'apellidos'},
				{ data: 'tipo_documento.nombre'},
				{ data: 'nro_doc'},
				{ data: 'provincia.nombre'},
				{ data: 'acciones'}
				]
			});
		});

		$('.excel').on('click',function () {

			var filtros = getFiltrosJson();
			console.log(filtros);
			var order_by = $('#abm-table').DataTable().order();
			console.log(order_by);

			$.ajax({
				url: 'alumnos/excel',
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
				url: 'alumnos/pdf',
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

		$('#abm').on("click",".eliminar",function(){
			var alumno = $(this).attr("alumno-id");
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
						text: '¿Esta seguro que quiere dar de baja al alumno?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						var data = '_token='+$('#abm input').first().val();

						$.ajax ({
							url: 'alumnos/'+alumno,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro el alumno.');
								location.reload("true");
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

		$('#alta_alumno').on("click",function(){
			$('#filtros .box').hide();
			$('#abm').hide();
			$.ajax({
				url: 'alumnos/alta',
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				}
			})
		});

		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear el usuario.');
			$('#alta').html("");
			$('#abm').show();
			$('#filtros .box').show();
		});

			/*$('#abm').on("click",".editar",function(){
				$('#filtros .box').hide();
				$('#abm').hide();
				var alumno = $(this).attr("alumno-id");
				$.ajax({
					url: 'alumnos/'+alumno,
					method: 'get',
					success: function(data){
						$('#alta').html(data);
						$('#alta').show();

						$('#alta').find('#cursos-table').DataTable({					
							searching: false,
							ajax : 'cursos/alumno/'+alumno,
							columns: [
							{ data: 'Nombre curso'},
							{ data: 'Horas duracion'},
							{ data: 'Modalidad'},				
							{ data: 'Provincia organizadora'}
							]
						});
					}
				});			
			});*/

			$('#limpiar').on("click",function(){
				console.log('voy a borrar');
				$('.form-control').val('');
				$(this).closest('.box-footer').hide();
			});		

			/*$('#alta').on("click","#modificar",function(){
				var alumno = $(this).attr("alumno-id");
				jQuery('<div/>', {
					id: 'dialogModificacion',
					text: ''
				}).appendTo('.container');

				$("#dialogModificacion").dialog({
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
							id: 'dialogModificacion',
							text: '¿Esta seguro que quiere modificar al alumno?'
						}).appendTo('#dialogModificacion');
					},
					buttons :
					{
						"Aceptar" : function () {
							$(this).dialog("destroy");
							$("#dialogModificacion").html("");

							$.ajax({				
								url : 'alumnos/'+alumno,
								method : 'put',
								data : $('form').serialize(),
								success : function(data){
									console.log("Success.");
									location.reload("true");			
								},
								error : function(data){
									console.log("Error.");
								}
							});

						},
						"Cancelar" : function () {
							$(this).dialog("destroy");
							$("#dialogModificacion").html("");
						}
					}				
				});			
			});*/

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

		})
	</script> 
	@endsection

