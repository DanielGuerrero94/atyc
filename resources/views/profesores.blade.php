@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">		
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('profesores.filtros')
		</div>
	</div>
	<div class="row">
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('profesores.abm')
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

	$.fn.dataTable.ext.search.push(
		function( settings, data, dataIndex ) {
        var nro_doc = data[3] || 0; // use data for the age column
        return nro_doc == $('#nro_doc').val();
    }
    );    

	$(document).ready(function(){		

		@include('profesores.tutorial-base')

		function seeButton(id_profesor) {
			return '<a href="{{url("/profesores")}}/' + id_profesor + '/see" data-id="' + id_profesor + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
		}

		function editButton(id_profesor) {
			return '<a href="{{url("/profesores")}}/' + id_profesor + '" data-id="' + id_profesor + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
		}

		function deleteButton(id_profesor) {
			return '<a href="#" data-id="' + id_profesor + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
		}

		$('#abm').on('click','.filter',function () {			
			$('#filtros .box').show();
		});

		var datatable = $('#table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'profesores/tabla',
			columns: [
			{ data: 'nombres', title: 'Nombres'},
			{ data: 'apellidos', title: 'Apellidos'},
			{ data: 'nro_doc', title: 'Nro Doc'},
			{ title: 'Tipo Documento', data: 'tipo_documento.nombre', name: 'id_tipo_documento'},			
			{ title: 'Tipo Docente', data: 'tipo_docente.nombre', name: 'id_tipo_docente'},			
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
					return seeButton(row.id_profesor) + editButton(row.id_profesor) + deleteButton(row.id_profesor);
				},
				orderable: false
			}
			],
			responsive: true
		});

		$('#filtros').on('click','#filtrar',function () {

			filtros = $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray();

			datatable = $('#table').DataTable({
				destroy: true,
				searching: false,
				ajax: {
					url: 'profesores/filtrado',
					data: {
						filtros: filtros 
					}
				},
				columns: [
				{ data: 'nombres', title: 'Nombres'},
				{ data: 'apellidos', title: 'Apellidos'},
				{ data: 'nro_doc', title: 'Nro Doc'},
				{ title: 'Tipo Documento', data: 'tipo_documento.nombre', name: 'id_tipo_documento'},			
				{ title: 'Tipo Docente', data: 'tipo_docente.nombre', name: 'id_tipo_docente'},	
				{ 
					data: 'acciones',
					name: '',
					render: function ( data, type, row, meta ) {
						return seeButton(row.id_profesor) + editButton(row.id_profesor) + deleteButton(row.id_profesor);
					},
					orderable: false
				}
				],
				responsive: true
			});
		});

		$('.excel').on('click',function () {

			filtros = $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray();

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

			filtros = $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray();

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
					window.location="/descargar/pdf/"+data;
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
	});
</script> 
@endsection
