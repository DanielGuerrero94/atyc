@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Material</h3>
			@if(Auth::user()->id_provincia === 25)
			<div class="btn-group pull-right">
				<div type="button" class="btn btn-box-tool" id="configure" data-toggle=false>
					<i class="fa fa-gear"  style="color: #2F2D2D;"></i>
				</div>
				<div  class="btn btn-box-tool">
					<form id="upload" name="upload">
						{{ csrf_field() }}
						<label style="cursor: pointer;color: #2F2D2D;">
							<input type="file" style="display: none;" name="csv">
							<i class="fa fa-cloud-upload"></i> Subir
						</label>
					</form>
				</div>
			</div>
			@endif
		</div>
		<div class="box-body">
			<div id="list">
			</div>
		</div>
	</div>				
</div>
@endsection

@section('script')
<script type="text/javascript">

	var downloadButton = '<a href="#" class="btn download"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"> Descargar</i></a>';
	var updateButton = '<a href="#" class="btn update" title="Actualizar"><i class="fa fa-cloud-upload fa-lg text-primary"></i></a>';;
	var editButton = '<a href="#" class="btn edit" title="Editar"><i class="fa fa-pencil fa-lg text-info"></i></a>';;
	var deleteButton = '<a href="#" class="btn delete" title="Borrar"><i class="fa fa-trash-o fa-lg text-danger"></i></a>';

	function changeToDownload() {
		$('#list .buttons').each(function(key,value){
			$(value).html(downloadButton);
		});
	}

	function changeToEdit() {
		$('#list .buttons').each(function(key,value){
			let buttons = $(value);
			buttons.html("");
			$(updateButton).appendTo(buttons);
			$(editButton).appendTo(buttons);
			$(deleteButton).appendTo(buttons);
		});
	}

	function filenameFix() {
		$('#list .filename').each(function (key,value){
			let val = $(value);
			let match = val.html().match(/.{1,30}/g);
			let words = [];
			for(word of match){
				words.push(word + '<br>');
			}
			val.html(words.join(""));
		});
	}

	function descriptionFix() {
		$('#list .description span').each(function (key,value){
			let val = $(value);
			val.attr('tittle', val.html());
			let match = val.html().substr(0, 30);
			val.html(match);
			$(value).find('i').removeClass("fa-angle-up").addClass("fa-angle-down");
		});
	}

	$(document).ready(function(){

		$.ajax({
			url: "{{url('/materiales/list')}}",
			success: function (data) {
				$(".container-fluid #list").html(data);
				descriptionFix();
				changeToDownload();
			},
			error: function (data) {
				alert("Error al cargar documentacion.");
				location.reload();
			}
		});

		$(".container-fluid").on("click", '.download', function(event) {
			event.preventDefault();
			let id = $(this).parent().data("id");
			location.href = "{{url('/materiales')}}" + "/" + id + "/download";
		});

		$(".container-fluid").on('mouseleave', '.material', function(event) {
			event.preventDefault();
			let more = $(this).find('.more');	
			if (!more.data("toggle")) {
				let span = more.parent().find('span');
				span.animate({height: "20px"}, "slow");
				span.html(span.html().substr(0, 30));
				more.data("toggle", true);
				more.find('i').removeClass("fa-angle-up").addClass("fa-angle-down");
			}				
		});

		$(".container-fluid").on("click", ".more", function(event) {
			event.preventDefault();
			let more = $(this);
			let span = more.parent().find('span');
			if (more.data("toggle")) {
				span.html(span.attr('tittle'));
				more.data("toggle", false);
				$(this).find('i').removeClass("fa-angle-down").addClass("fa-angle-up");
			} else {
				span.animate({height: "20px"}, "slow");
				span.html(span.html().substr(0, 30));
				more.data("toggle", true);
				$(this).find('i').removeClass("fa-angle-up").addClass("fa-angle-down");
			}			
		});

		@if(Auth::user()->id_provincia === 25)

		function formDescripcion(id){
			return '<form id="description">{{ csrf_field() }}{{ method_field('PUT') }}<label for="descripcion"><input type="text" id="descripcion" name="descripcion"></label></form>';
		}

		function formUpdate(id){
			return '<form id="update" name="update">{{ csrf_field() }}{{ method_field('PUT') }}<label style="cursor: pointer;color: #2F2D2D;"><input type="file" style="display: none;" name="csv"><i class="fa fa-cloud-upload"></i></label></form>';
		}

		$(".container-fluid").on('change', '#upload input', function(event) {
			data = new FormData($('#upload')[0]);

			$.ajax({
				url: '{{url('materiales')}}',
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
				},
				error: function (data) {
					alert("Error al subir un archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", "#configure", function(event) {
			event.preventDefault();
			configure = $(this);
			if (configure.data('toggle')) {
				changeToDownload();
				configure.data("toggle", false);
			} else {
				changeToEdit();
				configure.data("toggle", true);
			}			
		});

		$(".container-fluid").on("click", ".update", function(event) {
			data = new FormData($('#upload')[0]);			
			$.ajax({
				url: "{{url('/materiales')}}",
				data: data,
				type: 'put',
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
				},
				error: function (data) {
					alert("Error al subir un archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", ".edit", function(event) {
			$.ajax({
				url: '{{url('materiales')}}',
				type: 'post',
				data: data,
				processData: false,
				contentType: false,
				success: function (data) {
					console.log("success");
				},
				error: function (data) {
					alert("Error al subir un archivo.");
					location.reload();
				}
			});
		});

		$(".container-fluid").on("click", ".delete", function(event) {
			event.preventDefault();

			id = $(this).parent().data('id');

			jQuery('<div/>', {
				id: 'dialogDelete',
				text: ''
			}).appendTo('.container-fluid');

			$("#dialogDelete").dialog({
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
						id: 'dialogDelete',
						text: '¿Esta seguro que quiere borrar el archivo?'
					}).appendTo('#dialogDelete');
				},
				buttons :
				{
					"Aceptar" : function () {
						$(this).dialog("destroy");
						$("#dialogDelete").html("");
						_token = $('.container-fluid #upload').children().val();

						$.ajax({
							url: '{{'materiales/'}}' + id,
							type: 'DELETE',
							data: {'_token': _token},
							success: function (data) {
								console.log("success");
								location.reload("true");
							},
							error: function (data) {
								alert("Error al borrar.");
								location.reload("true");
							}
						});
					},
					"Cancelar" : function () {
						$(this).dialog("destroy");
						$("#dialogDelete").html("");
						location.reload("true");
					}
				}
			});			
		});		

		@endif

	});

</script> 
@endsection

