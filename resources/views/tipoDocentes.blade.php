@extends('layouts.adminlte')

@section('content')
<div class="row">
	<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		@include('tipoDocentes.abm')
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

		$('[data-toggle="popover"]').popover(); 

		$('#abm .table').DataTable({
			scrollCollapse: true,
			ajax : 'tipoDocentes/table',
			columns: [
			{ data: 'nombre'},
			{ data: 'desde'},
			{ data: 'hasta'},
			{ data: 'acciones'}
			]
		});

		$('#abm').on('click','#nuevo_periodo',function() {
			$.ajax ({
				url: 'periodos/create',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#abm').hide();
				}
			});
		});

		$('#alta').on('click','#volver',function() {
			$('#abm').show();
			$('#alta').hide();
		});

		/*$('#abm').on('click','.editar',function() {
			$.ajax ({
				url: 'periodos/' + $(this).data('id'),
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#abm').hide();
				}
			});
		});*/

		$('#abm').on("click",".eliminar",function(){
			var periodo = $(this).data('id');
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
						text: '¿Esta seguro que quiere dar de baja el periodo?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");				

						$.ajax ({
							url: 'periodos/' + periodo,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro el periodo.');
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

		/*$('#alta').on('click','#modificar',function() {
			$.ajax({				
				url : 'periodos/' + $(this).data('id'),
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
		});*/

	});	

</script>
@endsection