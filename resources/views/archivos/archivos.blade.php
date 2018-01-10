@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Documentación - Ejecución</h3>
			<div class="btn-group pull-right">
				<a href="#" class="btn btn-box-tool" id="list-view" tittle="Listar" data-toggle=true>
					<i class="fa fa-list fa-lg" style="color: #2F2D2D;"></i>
				</a>
				@if(Auth::user()->id_provincia === 25)
				<div  class="btn btn-box-tool" tittle="Subir archivo">
					<form id="upload" name="upload">
						{{ csrf_field() }}
						<label style="cursor: pointer;color: #2F2D2D;">
							<input type="file" style="display: none;" name="csv">
							<i class="fa fa-lg fa-cloud-upload"></i> Subir
						</label>
					</form>
				</div>
				<div type="button" class="btn btn-box-tool" id="configure" tittle="Configurar" data-toggle=false>
					<i class="fa fa-lg fa-gear"  style="color: #2F2D2D;"></i>
				</div>
				@endif			
			</div>
		</div>
		<div class="box-body">
			<div id="list">
			</div>
			<div id="grid" style="display: none;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Archivo</th>
							<th>Descripción</th>
							<th>Ultima modificación</th>
							<th>Acciones</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>				
</div>
@endsection

@section('script')
<script type="text/javascript">

	var downloadButton = '<a href="#" class="btn download"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"> Descargar</i></a>';	

	function downloadAction(id) {
		return '<a href="{{url('/materiales')}}/' + id + '/download" class="btn" tittle="Descargar"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"></i></a>';		
	}

	function changeToDownload() {
		$('#list .buttons').each(function(key,value){
			$(value).html(downloadButton);
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
			if (val.html().length > 30) {
				val.attr('tittle', val.html());
				let match = val.html().substr(0, 30);
				val.html(match);
				$(value).find('i').removeClass("fa-angle-up").addClass("fa-angle-down");	
			}			
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
				location.href = "{{url('/dashboard')}}";
			}
		});

		$(".container-fluid").on("click", '.download', function(event) {
			event.preventDefault();
			let id = $(this).closest(".box-footer").data("id");
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

		$(".container-fluid").on("click", '#list-view', function(event) {
			event.preventDefault();
			listView = $(this);
			if (listView.data("toggle")) {
				listView.children().removeClass("fa-list").addClass("fa-th");
				$(".container-fluid #list").hide();
				$(".container-fluid #configure").hide();
				$(".container-fluid #grid").show();
				gridView()
				listView.data("toggle", false);
			} else {
				$(".container-fluid #grid").hide();
				$(".container-fluid #list").show();
				$(".container-fluid #configure").show();
				listView.children().removeClass("fa-th").addClass("fa-list");
				listView.data("toggle", true);
			}	
		});

		function gridView() {

			$(".container-fluid #grid .table").DataTable({
				debug: true,
				destroy: true,
				searching: true,
				ajax : "{{url('/materiales/table')}}",
				columns: [
				{ data: 'original', tittle: 'Archivo', name: 'Archivo'},
				{ data: 'descripcion', tittle: 'Descripción', name: 'Descripción'},
				{ data: 'updated_at', tittle: 'Ultima modificacion'},
				{ 
					data: 'id_material',
					tittle: 'acciones',
					render: function ( data, type, row, meta ) {
						return downloadAction(data);
					},
					orderable: false
				}
				],
				responsive: true
			});
		}

	});

</script> 
@if(Auth::user()->id_provincia === 25)
@include('archivos.script')		
@endif
@endsection

