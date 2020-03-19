@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('pacs.filtros')
		</div>
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('pacs.abm')
		</div>
	</div>
	<div class="row">
		<div id="alta-pac" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	
	function getFiltros(){
			filtros = $('#form-filtros :input')
			.filter(function(i,e){return $(e).val() != "" || $(e).val() != "0"})
			.serializeArray()
			.map(function(obj) { 
				var r = {};
				r[obj.name] = obj.value;
				return r;
			});

			filtros.push({capacitados: $("#form-filtros #capacitados").data("check")});
			return filtros;
		}

	function createDatatable(){
	
	datatable = $('#abm-table').DataTable({
			destroy: true,
			responsive: true,
			searching: false,
			ajax : {
				url: "{{url('pacs/filtrar')}}",
				data: {
					filtros: getFiltros()
				}
			},
			columns: [
			{ data: 'nombre'},
			{ data: 'tipo_accion'},
			{ data: 'duracion'},
			{ data: 't3'},
			{ data: 't4'},
			{ data: 'observado'},
			{ data: 'acciones',"orderable": false}
			],			
			rowReorder: {
				selector: 'td:nth-child(2)'
			},
		});
	// datatable = $('.table').DataTable({
	// 		destroy: true,
	// 		responsive: true,
	// 		searching: false,
	// 		ajax : {
	// 				url: "{{url('/efectores/filtrar')}}",
	// 				data: {
	// 					filtros: getFiltros()
	// 				}
	// 			},
	// 		columns: [
	// 		{ name: 'id_provincia', data: 'provincia', title: 'Provincia'},
	// 		{ data: 'siisa', title: 'Siisa'},
	// 		{ data: 'cuie', title: 'Cuie'},
	// 		{ data: 'nombre', title: 'Nombre', orderable: false},
	// 		{ data: 'denominacion_legal', title: 'Denominación legal', orderable: false},
	// 		{ name: 'id_departamento', data: 'departamento', title: 'Departamento', orderable: false},
	// 		{ name: 'id_localidad', data: 'localidad', title: 'Localidad', orderable: false},
	// 		{ data: 'codigo_postal', title: 'Codigo postal', orderable: false},
	// 		{ data: 'ciudad', title: 'Ciudad', orderable: false},
	// 		{ 
	// 			data: 'acciones',
	// 			render: function ( data, type, row, meta ) {
	// 				return historialButton(row.cuie);
	// 			},
	// 			orderable: false
	// 		}
	// 		]
	// });
		
		return datatable;
	}

	$(document).ready(function(){

		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').show();
		});



		$('#alta_pac').on("click",function(){

			$.ajax({
				url: "{{url('pacs/alta')}}",
				type: 'get',
                beforeSend: function () {
                        $("#alta-pac").html("Procesando, espere por favor...");
                },				
				success: function(data){
					$('#alta-pac').html(data);
					$('#alta-pac').show();
					$('#abm').hide();
				}
			});
		});

		$("#alta-pac").on("click","#volver",function(){
			console.log('Se vuelve sin crear la pac.');
			$('#alta-pac').html("");
			$('#abm').show();
			$('#filtros').show();
		});

		$('#abm').on('click','.expand',function () {
			$('#abm').removeClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.compress').show();	
			$(this).hide();
		});

		$('#abm').on('click','.compress',function () {
			$('#abm').addClass("col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1");
			datatable.draw();
			$('.expand').show();	
			$(this).hide();	
		});

		$('#abm').on("click",".eliminar",function(){
			var pac = $(this).data('id');
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
						text: '¿Esta seguro que quiere dar de baja al profesor?'
					}).appendTo('#dialogABM');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogABM").html("");
						$.ajax ({
							url: 'pacs/'+pac,
							method: 'delete',
							data: data,
							success: function(data){
								console.log('Se borro la pac.');
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

		$('#alta-pac').on('click','#modificar',function() {

			var pac = $(this).data('id');

			$.ajax({				
				url : 'pacs/'+pac,
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