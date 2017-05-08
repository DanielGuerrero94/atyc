@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros" style="display: none;"></div>	
	<div id="abm">
		{{csrf_field()}}
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-tittle">Cursos
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
					<table id="abm-table" class="table table-hover">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Fecha</th>
								<th>Edicion</th>
								<th>Duracion</th>
								<th>Area tematica</th>
								<th>Linea estrategica</th>
								<th>Provincia</th>
								<th>Accion</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="alta_curso"><i class="fa fa-plus" aria-hidden="true"></i>Alta curso</button>
				</div>
			</div>
		</div>	
	</div>
	<div id="alta" style="display: none;"></div>				
</div>
@endsection
@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#abm').on('click','.filter',function () {

			$.ajax ({
				url: 'formularioConFiltros/cursos',
				method: 'get',
				success: function(data){
					$('#filtros').html(data);
					$('#filtros').show();
				}
			});

		});

		$('#abm-table').DataTable({
			searching: false,
			ajax : 'cursos/tabla',
			columns: [
			{ data: 'nombre'},
			{ data: 'fecha'},
			{ data: 'edicion'},
			{ data: 'duracion'},
			{ data: 'area_tematica'},
			{ data: 'linea_estrategica'},
			{ data: 'provincia'},
			{ data: 'accion'}
			]
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

		$('#abm').on("click",".editar",function(){
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
		});

		$("#alta").on("click","#volver",function(){
			console.log('Se vuelve sin crear el curso.');
			$('#alta').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		$("#alta").on("click","#modificar",function(){

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

