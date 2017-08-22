@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h2 class="box-tittle">Areas Tematicas</h2>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th>Fix</th>
								<th>Nombre</th>
								<th>Acciones</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="nueva_area_tematica"><i class="fa fa-plus" aria-hidden="true"></i>Nueva area tematica</button>
				</div>
			</div>
		</div>
	</div>
	<div id="alta"></div>	
</div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover(); 

		$('#table').DataTable({
			scrollCollapse: true,
			ajax : 'areasTematicasTabla',
			columns: [
			{ data: 'id_area_tematica'},
			{ data: 'nombre'},
			{ data: 'acciones'}
			]
		});

		$('#abm').on('click','#nueva_area_tematica',function() {
			console.log("Test");
			$.ajax ({
				url: 'areasTematicas/alta',
				method: 'get',
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

	$('#abm').on('click','.editar',function() {
		
		var area = $(this).data('id');

		$.ajax ({
			url: 'areasTematicas/'+area,
			success: function(data){
				$('#alta').html(data);
				$('#alta').show();
				$('#abm').hide();
			}
		});
	});

	$('#abm').on("click",".eliminar",function(){
		var area = $(this).data('id');
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
					text: '¿Esta seguro que quiere dar de baja al alumno?'
				}).appendTo('#dialogABM');
			},
			buttons :
			{
				"Aceptar" : function () {
					$(this).dialog("destroy");
					$("#dialogABM").html("");				

					$.ajax ({
						url: 'areasTematicas/'+area,
						method: 'delete',
						data: data,
						success: function(data){
							console.log('Se borro el area tematica.');
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

		var area = $(this).data('id');

		$.ajax({				
			url : 'areasTematicas/'+area,
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