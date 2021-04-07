@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
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
<!-- Moment.js -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
		
<script type="text/javascript">

	function createdAtValidDate(created_at) {	
		var created_date = moment(created_at);
		var current_date = moment();

		diff = current_date.diff(created_date, 'days');

		return diff <= 7; // se creo la misma semana
	}

	function acciones(deleted_at, created_at, id) {
		$buttons = '<a data-id="'+id+'" class="btn btn-circle editar" '+
		'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>';

		if(deleted_at)
			$buttons += '<a data-id="'+id+'" class="btn btn-circle darAlta" '+
			'title="Dar de alta" style="margin-right: 1rem;"><i class="fa fa-plus" aria-hidden="true" style="color: forestgreen;"></i></a>';
		else
			$buttons += '<a data-id="'+id+'" class="btn btn-circle darBaja" '+
			'title="Dar de baja" style="margin-right: 1rem;"><i class="fa fa-minus" aria-hidden="true" style="color: firebrick;"></i></a>';
		
		if(createdAtValidDate(created_at))
			$buttons += '<a data-id="'+id+'" class="btn btn-circle eliminar" '+
		'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';

		return $buttons;
	}

	$(document).ready(function(){
		$('[data-toggle="popover"]').popover(); 

		$('#table').DataTable({
			scrollCollapse: true,
			ajax : 'componentesTabla',
			columns: [
			{ title: 'id', data: 'id_componente', orderable: false},
            { title: 'Numero', data: 'numero'},
			{ title: 'Nombre', data: 'nombre'},
			{ title: 'Acciones', data: 'deleted_at',
				render: function( data, type, row, meta ) {
					return acciones(data, row.created_at, row.id_componente);
				}
			}]
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
							alert('Se borro el componente');
							$('#table').DataTable().clear().draw();
						},
						error: function (data) {
							alert("Hay un curso usando ese componente. No se puede borrar el registro");t
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
				alert("Se modifico al componente");
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
				alert("Se dio de baja el componente");
                $('#table').DataTable().clear().draw();
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
				alert("Se dio de alta el componente");
                $('#table').DataTable().clear().draw();
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