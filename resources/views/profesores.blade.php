@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros" style="display: none;"></div>
	<div id="abm">
		{{ csrf_field() }}	
		<div class="col-xs-12 ">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-tittle">Profesores
						<div class="btn-group pull-right" role="group" aria-label="...">
							<div type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></div>
							<div type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></div>
							<div type="button" class="btn btn-info filter" title="Filtro"><i class="fa fa-sliders" aria-hidden="true"></i></div>
							<div type="button" class="btn btn-info expand" title="Expandir"><i class="fa fa-expand" aria-hidden="true"></i></div>
							<div type="button" class="btn btn-info compress" title="Comprimir" style="display: none;"><i class="fa fa-compress" aria-hidden="true"></i></div>	
						</div>
					</h2>
				</div>
				<div class="box-body">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Tipo Doc</th>
								<th>Nro Doc</th>
								<th>Acciones</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="alta_profesor"><i class="fa fa-plus" aria-hidden="true"></i>Alta Profesor</button>
				</div>
			</div>
		</div>
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

			$.ajax ({
				url: 'formularioConFiltros/profesors',
				method: 'get',
				success: function(data){
					$('#filtros').html(data);
					$('#filtros').show();
				}
			});

		});

		$('#table').DataTable({
			searching: false,
			ajax : 'profesoresTabla',
			columns: [
			{ data: 'nombres'},
			{ data: 'apellidos'},
			{ data: 'tipo_doc'},
			{ data: 'nro_doc'},
			{ data: 'acciones'}
			]
		});

		$('#filtros').on('click','#filtrar',function () {
			console.log("sadas");
			$.ajax({
				url: 'profesores/filtrado',
				method: 'get',
				data: $('#form-filtros').serialize(),
				success: function(data){
					console.log('Success');
					console.log(data);

					$('#table').DataTable({
						searching: false,
						data: data,
						columns: [
						{ data: 'nombres'},
						{ data: 'apellidos'},
						{ data: 'tipo_doc'},
						{ data: 'nro_doc'},
						{ data: 'acciones'}
						]
					});
				},
				error: function (data) {
					console.log('Error');
				}
			})
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

		$('#abm').on("click",".editar",function(){
			$('#filtros').hide();
			$('#abm').hide();
			var profesor = $(this).data('id');
			$.ajax({
				url: 'profesores/'+profesor,
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				}
			});			
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