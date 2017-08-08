@extends('layouts.adminlte')

@section('content')
<div class="row ">
	<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		@include('alumnos.filtros')
	</div>
</div>
<div class="row">
	<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		@include('alumnos.abm')
	</div>  
</div>	
<div class="row">
	<div id="alta" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">		
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});

		$('#abm').on('click','.expand',function () {
			$('#abm').removeClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('#abm').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			$('.expand').show();	
			$(this).hide();	
		});

		$('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'alumnos/tabla',
			columns: [
			{ data: 'nombres'},
			{ data: 'apellidos'},
			{ name: 'id_tipo_documento',data: 'tipo_documento.nombre'},
			{ data: 'nro_doc'},
			{ data: 'provincia.nombre'},
			{ data: 'acciones', orderable: false}
			],
			pagingType: 'simple' 
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
				searching: false,
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
				{ data: 'id_tipo_documento',orderable: false},
				{ data: 'nro_doc'},
				{ data: 'provincia'},
				{ data: 'acciones', orderable: false}
				],			
				rowReorder: {
					selector: 'td:nth-child(2)'
				},
				responsive: true
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
			var alumno = $(this).data("id");
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

		$('#limpiar').on("click",function(){
			console.log('voy a borrar');
			$('.form-control').val('');
			$(this).closest('.box-footer').hide();
		});	

	});

</script> 
@endsection

