@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros">
		@include('profesores.filtros')
	</div>
	<div id="abm">
		@include('profesores.abm')
	</div>	
	<div id="alta" style="display: none;"></div>				
</div>
@endsection
@section('script')

<script type="text/javascript">

	$.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
        var nro_doc = data[3] || 0; // use data for the age column
        return nro_doc == $('#nro_doc').val();
    }
    );

	$(document).ready(function(){

		$('#abm').on('click','.filter',function () {			
			$('#filtros .box').show();
		});

		$('#table').DataTable({
			destroy: true,
			ajax : 'profesores/tabla',
			columns: [
			{ data: 'nombres'},
			{ data: 'apellidos'},
			{ data: 'tipo_documento.nombre'},
			{ data: 'nro_doc'},
			{ data: 'acciones'}
			]
		});

		function getFiltrosJson() {
			var nombres = $('#nombres')	.val();
			var apellidos = $('#apellidos').val();
			var id_tipo_doc = $('#tipo_doc option:selected').val()
			var id_pais = $('#nacionalidad').val();
			var nro_doc = $('#nro_doc').val();
			var email = $('#email').val();
			var cel = $('#cel').val();
			var tel = $('#tel').val();

			return data = {
				nombres: nombres,
				apellidos: apellidos,
				id_tipo_doc: id_tipo_doc,
				id_pais: id_pais,
				nro_doc: nro_doc,
				email: email,
				cel: cel,
				tel: tel};
			};

			$('#filtros').on('click','#filtrar',function () {

				var filtrosJson = getFiltrosJson();
				console.log(filtrosJson);

				$('#table').DataTable({
					destroy: true,
					ajax: {
						url: 'profesores/filtrado',
						data: {
							filtros: filtrosJson 
						}
					},
					columns: [
					{ data: 'nombres'},
					{ data: 'apellidos'},
					{ data: 'tipo_documento.nombre'},
					{ data: 'nro_doc'},
					{ data: 'acciones'}
					]
				});
			});

			$('.excel').on('click',function () {

				var filtros = getFiltrosJson();
				console.log(filtros);
				var order_by = $('#table').DataTable().order();
				console.log(order_by);

				$.ajax({
					url: 'profesores/excel',
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
				var order_by = $('#table').DataTable().order();
				console.log(order_by);			

				$.ajax({
					url: 'profesores/pdf',
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

			$('#alta_profesor').on('click',function () {
				$('#filtros').hide();
				$('#abm').hide();
				$.ajax({
					url: 'profesores/alta',
					method: 'get',
					success: function(data){
						$('#alta').html(data);
						$('#alta').show();
					}
				})
			});

		$('#abm').on("click",".eliminar",function(){
			var profesor = $(this).data('id');
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
						var data = '_token='+$('#abm input').first().val();
						console.log(profesor);

						$.ajax ({
							url: 'profesores/'+profesor,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro el profesor.');
							},
							error: function (data) {
								console.log('Hubo un error.');
								console.log(data);
							}
						});

						location.reload("true");

					},
					"Cancelar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						location.reload("true");
					}
				}
			});
		});

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
	});
</script> 
@endsection