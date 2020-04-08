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
<script type="text/javascript" src="{{"//cdn.datatables.net/plug-ins/1.10.20/dataRender/datetime.js"}}"></script>
<script type="text/javascript" src="{{"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"}}"></script>

<script type="text/javascript">


	@if(Auth::user()->id_provincia === 25)
	function tableButtons(data) {
		return seeButton(data) + editButton(data) + deleteButton(data);
	}
	@else
	function tableButtons(data) {
		return seeButton(data) + editButton(data);
	}
	@endif

    function seeButton(id_pac) {
	    return '<a href="{{url("/pacs")}}/' + id_pac + '/see" data-id="' + id_pac + '" class="btn btn-circle ver" title="Ver"><i class="fa fa-search text-info fa-lg"></i></a>';
	}

	function editButton(id_pac) {
		return '<a href="{{url("/pacs")}}/' + id_pac + '/edit" data-id="' + id_pac + '" class="btn btn-circle editar" title="Editar"><i class="fa fa-pencil text-info fa-lg"></i></a>';
	}

	function deleteButton(id_pac) {
			return '<a href="#" data-id="' + id_pac + '" class="btn btn-circle eliminar" title="Eliminar"><i class="fa fa-trash text-danger fa-lg"></i></a>';
	}

	function fichaTecnica(id_ficha, id_pac) {
		if(id_ficha)
		{	
			return '<a href="{{url("/pacs/ficha_tecnica")}}/' + id_ficha + '/download" data-id="'+ id_ficha + '" class="btn btn-circle download-ficha_tecnica" title="Descargar Ficha Tecnica"><i class="fa fa-download fa-lg" style="color: #2F2D2D;"></i></a> <a href="#" data-id="'+ id_ficha + '" class="btn btn-circle update-ficha_tecnica" title="Reemplazar Ficha Técnica"><i class="fa fa-cloud-upload fa-lg text-primary"> </i> </a> ';
		} else
		{
			return '<a href="#" data-id="' + id_pac + '" class="btn btn-circle upload-ficha_tecnica" title="Subir Ficha Técnica"><i class="fa fa-upload fa-lg" style="color: #228B22;"> </i> </a> ';
		}
	}

	$(document).ready(function(){
		
		formUpload = '<form id="upload-ficha_tecnica" name="upload-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';

		formUpdate = '<form id="update-ficha_tecnica" name="update-ficha_tecnica" style="display: none;">{{ csrf_field() }}<label><input type="file" name="csv" style="display: none;"></label></form>';
		
		$('#abm').on('click','.filter',function () {
			$('#filtros .box').toggle();
		});

		datatable = $('#abm-table').DataTable({
			destroy: true,
			searching: false,
			ajax : 'pacs/tabla',
			columns: [
			{
				title: 'Fecha', 
				data: 'created_at',
				defaultContent: '-',
				render:function(data){
      				return moment(data).format('DD/MM/YYYY');
				}
			},
			{ title: 'Nombre', data: 'nombre'},
			{ title: 'Ediciones', data: 'ediciones'},
			{ title: 'Duracion', data: 'duracion'},			
			{ title: 'Tematica/s', data: 'tematicas', defaultContent: '-', name: 'id_tematica',
				render: function ( data, type, row, meta)
				{
					if(Object.entries(data).length != 0)
						return data.map(function(tematica) { return ' ' + tematica.nombre; });
				},
				orderable: false
			},
			{ title: 'Tipo de Accion', data: 'tipo_accion.nombre', name: 'id_accion'},
			{ title: 'Jurisdiccion', data: 'provincias.nombre', name: 'id_provincia'},
			{
				title: 'Ficha Técnica', data: 'id_ficha_tecnica',
				render: function ( data, type, row, meta ) {
					return fichaTecnica(data, row.id_pac);
				},
				orderable: false
			},
//			{ title: 'Estados' },
			{ 
				data: 'acciones',
				render: function ( data, type, row, meta ) {
                    return tableButtons(row.id_pac);
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
			console.log('Se vuelve sin crear la PAC.');
			$('#alta-pac').html("");
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
						text: '¿Esta seguro que quiere dar de baja la pac?'
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

		$(".container-fluid").on("click", ".upload-ficha_tecnica", function(event) {
			$(formUpload).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#upload-ficha_tecnica input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
			id_pac = form.parent().find(".upload-ficha_tecnica").data("id");
			$.ajax({
				url: "{{url('pacs')}}" + "/" + id_pac,
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al subir el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", ".update-ficha_tecnica", function(event) {
			$(formUpdate).appendTo($(this).parent());
			$(this).parent().find("form input").click();
		});

		$(".container-fluid").on("change", "#update-ficha_tecnica input", function(event) {
			form = $(this).parent().parent();
			data = new FormData(form[0]);
			id_ficha = form.parent().find(".update-ficha_tecnica").data("id");			
			$.ajax({
				url: "{{url('pacs/fichas_tecnicas')}}" + "/" + id_ficha,
				type: 'put',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
					location.reload();
				},
				error: function (data) {
					alert("Error al actualizar el archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", '.download-ficha_tecnica', function(event) {
			event.preventDefault();
			let id = $(this).data("id");
			location.href = "{{url('/pacs/fichas_tecnicas')}}" + "/" + id + "/download";
		});
		
	});


	// function fichaTecnica(id_pac) {
	// 	if(id_pac->)
	// 	return '<a href="{{url("/pacs/fichas_tecnicas")}}/' + id_pac '" class =
	// }

		
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

</script> 
@endsection