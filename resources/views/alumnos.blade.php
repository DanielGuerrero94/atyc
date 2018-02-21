@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
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
</div>
@endsection

@section('script')
<script type="text/javascript">

	function seeButton(id_alumno) {
		return '<a href="{{url("/alumnos")}}/' + id_alumno + '/see" data-id="' + id_alumno + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}

	function editButton(id_alumno) {
		return '<a href="{{url("/alumnos")}}/' + id_alumno + '" data-id="' + id_alumno + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_alumno) {
		return '<a href="#" data-id="' + id_alumno + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
	}

	$(document).ready(function(){

		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').toggle();
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

		datatable = $('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'alumnos/tabla',
			columns: [
			{ title: 'Nombres', data: 'nombres'},
			{ title: 'Apellidos', data: 'apellidos'},
			{ title: 'Nro Doc', data: 'nro_doc'},
			{ title: 'Tipo Documento', data: 'tipo_documento.nombre', name: 'id_tipo_documento'},			
			{ title: 'Provincia', data: 'provincia.nombre', name: 'id_provincia'},
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
					return seeButton(row.id_alumno) + editButton(row.id_alumno) + deleteButton(row.id_alumno);
				},
				orderable: false
			}
			],
			responsive: true
		});

		function getFiltros(){
			let select = $('#form-filtros select')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray();

			let input = $('#form-filtros input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray();

			return $.merge(input, select);
		}

		$('#filtros').on('click','#filtrar',function () {
			console.log(getFiltros());	

			datatable = $('#abm-table').DataTable({
				destroy: true,
				searching: false,
				ajax: {
					url: 'alumnos/filtrado',
					data: {
						filtros: getFiltros()
					}
				},
				columns: [
				{ title: 'Nombres', data: 'nombres'},
				{ title: 'Apellidos', data: 'apellidos'},
				{ title: 'Nro Doc', data: 'nro_doc'},
				{ title: 'Tipo Documento', data: 'tipo_documento.nombre', name: 'id_tipo_documento'},			
				{ title: 'Provincia', data: 'provincia.nombre', name: 'id_provincia'},
				{ 
					data: 'acciones',
					render: function ( data, type, row, meta ) {
						return seeButton(row.id_alumno) + editButton(row.id_alumno) + deleteButton(row.id_alumno);
					},
					orderable: false
				}
				],
				responsive: true
			});

		});

		$('.excel').on('click',function () {

			$.ajax({
				url: 'alumnos/excel',
				data: {
					filtros: getFiltros()
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

		$('#alta_alumno').on("click",function(){
			$('#filtros .box').hide();
			$('#abm').hide();
			$.ajax({
				url: 'alumnos/alta',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				}
			})
		});

		$('#limpiar').on("click",function(){
			console.log('voy a borrar');
			$('.form-control').val('');
			$(this).closest('.box-footer').hide();
		});	

	});

</script> 
@endsection

