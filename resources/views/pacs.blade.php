@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div id="filtros" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('pacs.filtros')
		</div>
	</div>
	<div class="row">
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


	function participantesLabel(cantidad) {
		return '<small class="label bg-blue" title="' + cantidad + ' Participantes"><i class="fa fa-users"> ' + cantidad + '</i></small>';
    }

    function seeButton(id_curso) {
	    return '<a href="{{url("/cursos")}}/' + id_curso + '/see" data-id="' + id_curso + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}

	function editButton(id_curso) {
		return '<a href="{{url("/cursos")}}/' + id_curso + '" data-id="' + id_curso + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_curso) {
		return '<a href="#" data-id="' + id_curso + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
	}

	// function getFiltros(){
	// 		filtros = $('#form-filtros :input')
	// 		.filter(function(i,e){return $(e).val() != "" || $(e).val() != "0"})
	// 		.serializeArray()
	// 		.map(function(obj) { 
	// 			var r = {};
	// 			r[obj.name] = obj.value;
	// 			return r;
	// 		});

	// 		return filtros;
	// 	}

	$(document).ready(function(){
		
		var datatable;

		$('#abm').on('click','.filter',function () {
			$('#filtros .box').toggle();
		});

		datatable = $('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'pacs/tabla',
			columns: [
			{ title: 'Nombre', data: 'nombre'},
			{ title: 'Fecha', data: 'fecha'},
			{ title: 'Edicion', data: 'edicion'},
			{ title: 'Duracion', data: 'duracion'},			
			{ title: 'Tematica', data: 'area_tematica.nombre', name: 'id_area_tematica'},
			{ title: 'Tipologia', data: 'linea_estrategica.nombre', name: 'id_linea_estrategica'},
			{ title: 'Jurisdiccion', data: 'provincia.nombre', name: 'id_provincia'},
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
                    //return /*participantesLabel(row.alumnos_count) + */
                    return seeButton(row.id_curso) + editButton(row.id_curso) + deleteButton(row.id_curso);
					// return data;
				},
				orderable: false
			}
			],
			responsive: true
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


		$('#altas_pac').on("click",function(){

			$.ajax({
				url: "{{url('pacs/alta')}}",
				method: 'get',
				success: function(data){
					$('#alta-pac').html(data);
					$('#alta-pac').show();
					$('#filtros').hide();
					$('#abm').hide();
				},
				error: function(data){
					console.log(data);
					alert("No se pudo cargar la view de alta de PAC");
				}
			});
		});

		$("#alta-pac").on("click","#volver",function(){
			console.log('Se vuelve sin crear el curso.');
			$('#alta-accion').html("");
			$('#abm').show();
			$('#filtros').show();
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
	});

</script> 
@endsection