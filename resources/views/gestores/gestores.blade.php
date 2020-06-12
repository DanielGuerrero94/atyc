@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h2 class="box-tittle">Gestores</h2>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<table id="abm-table" class="table table-hover"></table>
				</div>
				<div class="box-footer">
					<a class="btn btn-success pull-right" href="{{url('/registrar')}}">Registrar</a>
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

		$('#abm-table').DataTable({
			ajax : 'gestores/tabla',
			columns: [
			{ data: 'name', title: 'Usuario'},
			{ data: 'title', title: 'Descripcion'},
			{ data: 'email', title: 'Email'},
			{ data: 'acciones', title: 'Acciones', searchable: false}
			]
		});

		$('#abm').on('click','.editar',function() {
		
			var gestor = $(this).data('id');

			$.ajax ({
				url: 'gestores/'+gestor+'/edit',
				success: function(data){
					console.log(data);
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

		$('#alta').on('click','#modificar',function() {

		var gestor = $(this).data('id');

		$.ajax({				
			url : 'gestores/'+gestor,
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
		$('#abm').on("click",".eliminar",function(){
			var gestor = $(this).data('id');
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
						text: '¿Esta seguro que quiere dar de eliminar el usuario del gestor?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");				

						$.ajax ({
							url: 'gestores/'+gestor,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro el usuario.');
								location.reload();
							},
							error: function (data) {
								alert("No es posible borrar al usuario.");
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
	});

</script> 
@endsection

