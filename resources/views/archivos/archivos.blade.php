@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Material</h3>
			@if(Auth::user()->id_provincia === 25)
			<div class="btn-group pull-right">
				<div type="button" class="btn btn-box-tool" id="configure" data-toogle="off">
					<i class="fa fa-gear"  style="color: #2F2D2D;"></i>
				</div>
				<div  class="btn btn-box-tool">
					<form id="upload" name="upload">
						{{ csrf_field() }}
						<label style="cursor: pointer;color: #2F2D2D;">
							<input type="file" style="display: none;" name="csv">
							<i class="fa fa-upload"></i> Subir
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

	$(document).ready(function(){

		$.ajax({
			url: '{{'materiales/list'}}',
			success: function (data) {
				console.log('success');
				$(".container-fluid #list").html(data);
			}
		})
		.done(function() {

		})
		.fail(function() {
			alert("error");
		})
		.always(function() {
			console.log("complete");
		});

		@if(Auth::user()->id_provincia === 25)

		$(".container-fluid").on('change', '#upload input', function(event) {
			data = new FormData($('#upload')[0]);
			$.ajax({
				url: '{{url('materiales')}}',
				type: 'POST',
				data: data,
				processData: false,
				contentType: false,
			})
			.done(function() {
				console.log("success");
				location.reload();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});

		$(".container-fluid").on('click', '#configure', function(event) {
			event.preventDefault();

			if ($(this).data('toggle') === "on") {
				location.reload("true");
			}
			
			$('#list').children().each(function(key,value){
				$(value).children().children().eq(1).html('<span style="cursor: pointer;" id="delete"><i class="fa fa-trash-o" style="color: #ff0000;"></i> Borrar</span>');
			});	

			$(this).data('toggle', 'on');
		});

		$('.container-fluid').on('click', '#delete', function(event) {
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
						})
						.done(function() {
							console.log("success");
							location.reload("true");
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log("complete");
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

