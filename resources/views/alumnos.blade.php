@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros">
		@include('alumnos.filtros')
	</div>
	<div id="abm">
	{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Alumnos
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
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Tipo Doc</th>
								<th>Nro Doc</th>
								<th>Provincia</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="alta_alumno"><i class="fa fa-plus" aria-hidden="true"></i>Alta Alumno</button>
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

		//Para cargar el nombre que tienen que tener los formularios busco 
		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});

		$('#abm-table').DataTable({
			ajax : 'alumnosTabla',
			columns: [
			{ data: 'nombres'},
			{ data: 'apellidos'},
			{ data: 'tipo_documento.nombre'},
			{ data: 'nro_doc'},
			{ data: 'provincia.nombre'},
			{ data: 'action'}
			]
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

		$('#abm').on("click",".editar",function(){
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
		});

		$('#limpiar').on("click",function(){
			console.log('voy a borrar');
			$('.form-control').val('');
			$(this).closest('.box-footer').hide();
		});		

		$('#alta').on("click","#modificar",function(){
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

	})
</script> 
@endsection

