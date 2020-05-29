@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h2 class="box-tittle">Destinatarios</h2>
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
					<button class="btn btn-success pull-right" id="nuevo_destinatario"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo destinatario</button>
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
			ajax : 'destinatariosTabla',
			columns: [
			{ data: 'id_destinatario', orderable: false},
			{ data: 'nombre'},
			{ data: 'acciones', orderable: false}
			]
		});

		$('#abm').on('click','#nuevo_destinatario',function() {
			$.ajax ({
				url: 'destinatarios/alta',
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
		
		var destinatario = $(this).data('id');

		$.ajax ({
			url: 'destinatarios/'+destinatario,
			success: function(data){
				$('#alta').html(data);
				$('#alta').show();
				$('#abm').hide();
			}
		});
	});

	$('#abm').on("click",".eliminar",function(){
		var destinatario = $(this).data('id');
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
					text: '¿Esta seguro que quiere dar de baja al destinatario?'
				}).appendTo('#dialogABM');
			},
			buttons :
			{
				"Aceptar" : function () {
					$(this).dialog("destroy");
					$("#dialogABM").html("");				

					$.ajax ({
						url: 'destinatarios/'+destinatario+'/hard',
						method: 'delete',
						data: data,
						success: function(data){
							console.log('Se borro el destinatario: '+destinatario);
							location.reload();
						},
						error: function (data) {
							alert("Hay un curso usando ese destinatario. No se puede borrar el registro");
							console.log('Hubo un error.');
							console.log(data);
							location.reload();
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

		var destinatario = $(this).data('id');

		$.ajax({				
			url : 'destinatarios/'+destinatario,
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

	$('#abm').on('click','.darBaja',function() {
		
		var destinatario = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();
		console.log(destinatario);
		console.log(data);
		$.ajax ({
			url: 'destinatarios/'+destinatario,
			method: 'delete',
			data: data,
			success: function(data){
				console.log("Se dio de baja el destinatario: "+destinatario);
				location.reload();
			},
			error: function(data){
				console.log("Error.");
				console.log(data);
			}
		});
	});


	$('#abm').on('click','.darAlta',function() {
		
		var destinatario = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();

		$.ajax ({
			url: 'destinatarios/'+destinatario+'/alta',
			method: 'put',
			data: data,
			success: function(data){
				console.log("Se dio de alta el destinatario: "+destinatario);
				location.reload();
			},
			error: function(data){
				console.log("Error.");
				console.log(data);
			}
		});
	});

	
});	
</script>
@endsection