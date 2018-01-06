@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('alumnos.abm')
		</div>  
	</div>	
	<div class="row">
		<div id="alta" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">		
		</div>
	</div>	
</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#abm-table').DataTable({
			destroy: true,
			searching: true,
			ajax : "{{url('funciones/tabla')}}",
			columns: [
			{ data: 'nombre'},
			{ data: 'acciones', orderable: false}
			],
			responsive: true
		});

		$('.excel').on('click',function () {

			$.ajax({
				url: "{{url('/funciones/excel')}}",
				beforeSend: function () {
					alert('Se descargara pronto.');
				},
				success: function(data){
					console.log(data);
					window.location= "{{url('/descargar/excel')}}" + "/" + data;
				},
				error: function (data) {
					alert('No se pudo crear el archivo.');
					console.log(data);
				}
			});

		});

		$('#abm').on("click",".eliminar",function(){
			var funcion = $(this).data("id");

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
						text: '¿Esta seguro que quiere dar de baja la funcion?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						var data = '_token='+$('#abm input').first().val();

						$.ajax ({
							url: "{{url('/funciones')}}"+"/"+funcion,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro la funcion.');
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

		$('#alta_funcion').on("click",function(){
			$('#abm').hide();
			$.ajax({
				url: "{{url('/funciones/create')}}",
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				}
			})
		});

	});

</script> 
@endsection

