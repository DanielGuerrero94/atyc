@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div id="abm">
			@include('categoriasPautas.abm')
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

		var datatable = $('#table').DataTable({
			destroy: true,
			searching: false,
			ajax : "{{url('/categoriasPautas/tabla')}}",
			columns: [
			{ data: 'item'},
			{ data: 'nombre'},
			{ data: 'descripcion'},
			{ data: 'acciones', orderable: false}
			],			
			rowReorder: {
				selector: 'td:nth-child(2)'
			},
			responsive: true
		});


		$('#alta_categoria_pauta').on('click',function () {
			$('#filtros').hide();
			$('#abm').hide();
			$.ajax({
				url: 'categoriasPautas/alta',
				method: 'get'
			}).done(function(data){
				$('#alta').html(data);
				$('#alta').show();
			}).fail(function(){
				alert("error");
			});
		});

		$('#abm').on("click",".eliminar",function(){
			var categoria = $(this).data('id');
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
						text: '¿Esta seguro que quiere dar de baja la categoria pauta?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						var data = '_token='+$('#abm input').first().val();

						$.ajax ({
							url: 'categoriasPautas/'+categoria,
							method: 'delete',
							data: data
						}).done(function(data){
							console.log('Se borro la categoria pauta.');
							alert('Se borro la categoria pauta.');
						}).fail(function(){
							console.log('Hubo un error.');
							console.log(data);
							alert("Error, no se puede borrar");
						});

						location.reload("true");
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