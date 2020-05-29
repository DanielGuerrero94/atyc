@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h2 class="box-tittle">Componentes CAI</h2>
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
                                <th>Numero</th>
								<th>Nombre</th>
								<th>Acciones</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="nuevo_componente"><i class="fa fa-plus" aria-hidden="true"></i>Nuevo componente</button>
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
			ajax : 'componentesTabla',
			columns: [
			{ data: 'id_componente', orderable: false},
            { data: 'numero'},
			{ data: 'nombre'},
			{ data: 'acciones', orderable: false}
			]
		});

		$('#abm').on('click','#nuevo_componente',function() {
			$.ajax ({
				url: 'componentes/alta',
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
		
		var componente = $(this).data('id');

		$.ajax ({
			url: 'componentes/'+componente,
			success: function(data){
				$('#alta').html(data);
				$('#alta').show();
				$('#abm').hide();
			}
		});
	});

	$('#abm').on("click",".eliminar",function(){
		var componente = $(this).data('id');
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
					text: '¿Esta seguro que quiere dar de baja al componente?'
				}).appendTo('#dialogABM');
			},
			buttons :
			{
				"Aceptar" : function () {
					$(this).dialog("destroy");
					$("#dialogABM").html("");				

					$.ajax ({
						url: 'componentes/'+componente+'/hard',
						method: 'delete',
						data: data,
						success: function(data){
							console.log('Se borro el componente: '+componente);
							location.reload();
						},
						error: function (data) {
							alert("Hay un curso usando ese componente. No se puede borrar el registro");
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

		var componente = $(this).data('id');

		$.ajax({				
			url : 'componentes/'+componente,
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
		
		var componente = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();
		console.log(componente);
		console.log(data);
		$.ajax ({
			url: 'componentes/'+componente,
			method: 'delete',
			data: data,
			success: function(data){
				console.log("Se dio de baja el componente: "+componente);
				location.reload();
			},
			error: function(data){
				console.log("Error.");
				console.log(data);
			}
		});
	});


	$('#abm').on('click','.darAlta',function() {
		
		var componente = $(this).data('id');
		var data = '_token='+$('#abm input').first().val();

		$.ajax ({
			url: 'componentes/'+componente+'/alta',
			method: 'put',
			data: data,
			success: function(data){
				console.log("Se dio de alta el componente: "+componente);
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