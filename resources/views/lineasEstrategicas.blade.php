@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="abm">
		{{csrf_field()}}
		<div class="col-xs-8 col-xs-offset-2">
			<div class="box box-info">
				<div class="box-header with-border">
					<h2 class="box-tittle">Tipologias de accion</h2>
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
								<th>Numero</th>
								<th>Nombre</th>
								<th>Acciones</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="box-footer">
					<button class="btn btn-success pull-right" id="nueva_linea_estrategica"><i class="fa fa-plus" aria-hidden="true"></i>Nueva tipologia de accion</button>
				</div>
			</div>
		</div>
	</div>
	<div id="alta" style="display: none;">		
	</div>	
</div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){

		$('#table').DataTable({
			scrollCollapse: true,
			ajax : 'lineasEstrategicasTabla',
			columns: [
			{ data: 'numero'},
			{ data: 'nombre'},
			{ data: 'acciones'}
			]
		});

		$('#abm').on('click','#nueva_linea_estrategica',function() {
			console.log("Test");
			$.ajax ({
				url: 'lineasEstrategicas/alta',
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#abm').hide();
				}
			});
		});

		$('#abm').on('click','.editar',function() {

			var linea = $(this).data('id');

			$.ajax ({
				url: 'lineasEstrategicas/'+linea,
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#abm').hide();
				}
			});
		});

		$('#abm').on("click",".eliminar",function(){
			var linea = $(this).data('id');
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

						console.log(linea);

						$.ajax ({
							url: 'lineasEstrategicas/'+linea,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro la linea estrategica.');
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
						location.reload();
					}
				}
			});			
		});

		$('#alta').on('click','#modificar',function() {

			var linea = $(this).data('id');

			$.ajax({				
				url : 'lineasEstrategicas/'+linea,
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

		$('#alta').on('click','#volver',function() {
			$('#abm').show();
			$('#alta').hide();
			console.log('Vuelve sin hacer cambios.');
		});		

		$('#alta').on('click','#crear',function() {
			var validator = $('#alta #form-alta').validate({
				rules:{
					nombre: {
						required: true,
					},
					numero: {
						required: true,
						digits: true
					}
				},
				messages:{
					nombre : "Campo obligatorio",
					numero : "Tiene que ser un numero"
				},
				highlight: function(element)
				{
					console.log("highlight");
					console.log(element);
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				},				
				success: function(element)
				{
					console.log("validate success");
					$(element).text('').addClass('valid')
					.closest('.form-group').removeClass('has-error').addClass('has-success');
				},
				submitHandler : function(form){
					$.ajax({
						method : 'post',
						url : 'lineasEstrategicas',
						data : $('form').serialize(),
						success : function(data){
							console.log("Success.");
							alert('Se creo la tipologia de accion.');
							location.reload();	
						},
						error : function(data){
							console.log("Error.");
						}
					});
				}
			});

			if(validator.valid()){
				$('#alta #form-alta').submit();	
			}
		});
	});
</script>
@endsection
