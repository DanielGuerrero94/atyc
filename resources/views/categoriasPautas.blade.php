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

		$('#abm').on('click','.filter',function () {			
			$('#filtros .box').show();
		});

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

		$('#filtros').on('click','#filtrar',function () {

			filtros = $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != ""})
			.serializeArray();

			var datatable = $('#table').DataTable({
				destroy: true,
				searching: false,
				ajax: {
					url: 'categoriasPautas/filtrado',
					data: {
						filtros: filtros 
					}
				},
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
		});


		$('#alta_categoria_pauta').on('click',function () {
			$('#filtros').hide();
			$('#abm').hide();
			$.ajax({
				url: 'categoriasPautas/alta',
				method: 'get',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
				}
			})
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
							data: data,
							success: function(data){
								console.log('Se borro la categoria pauta.');
							},
							error: function (data) {
								console.log('Hubo un error.');
								console.log(data);
							}
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