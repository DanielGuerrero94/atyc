@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 id="etapa" class="box-title" data-id="{{$etapa->id_etapa}}">Documentación - {{$etapa->nombre}}</h3>
			<div class="btn-group pull-right">
				<a href="#" class="btn btn-box-tool" id="list-view" title="Listar" data-toggle=false>
					<i class="fa fa-th fa-lg" style="color: #2F2D2D;"></i>
				</a>
				@if(Auth::user()->id_provincia === 25)
				<div  class="btn btn-box-tool" title="Subir archivo">
					<form id="upload" name="upload">
						{{ csrf_field() }}
						<label style="cursor: pointer;color: #2F2D2D;">
							<input type="file" style="display: none;" name="csv">
							<i class="fa fa-lg fa-cloud-upload"></i> Subir
						</label>
					</form>
				</div>
				<div type="button" class="btn btn-box-tool" id="configure" title="Configurar" data-toggle=false style="display: none;">
					<i class="fa fa-lg fa-gear"  style="color: #2F2D2D;"></i>
				</div>
				@endif			
			</div>
		</div>
		<div class="box-body">
			<div id="grid"  style="display: none;">
			</div>
			<div id="list">
				<table class="table table-hover">
				</table>
			</div>
		</div>
	</div>				
</div>
@endsection

@section('script')
<script type="text/javascript">

	var downloadButton = '<a href="#" class="btn btn-circle download"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"> Descargar</i></a>';	
	var updateButton = '<a href="#" class="btn btn-circle update" title="Remplazar archivo"><i class="fa fa-cloud-upload fa-lg text-primary"></i></a>';;
	var deleteButton = '<a href="#" class="btn btn-circle delete" title="Borrar"><i class="fa fa-trash fa-lg text-danger"></i></a>';

	@if(Auth::user()->id_provincia === 25)
	function tableButtons(data) {
		//return downloadAction(data) + updateButton + deleteButton;
		return downloadAction(data);
	}
	@else
	function tableButtons(data) {
		return downloadAction(data);
	}
	@endif


	function downloadAction(id) {
		return '<a href="{{url('/materiales')}}/' + id + '/download" class="btn btn-circle" title="Descargar"><i class="fa fa-cloud-download fa-lg" style="color: #2F2D2D;"></i></a>';		
	}

	function changeToDownload() {
		$('#grid .buttons').each(function(key,value){
			$(value).html(downloadButton);
		});
	}

	function filenameFix() {
		$('#grid .filename').each(function (key,value){
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
		$('#grid .description span').each(function (key,value){
			let val = $(value);
			if (val.html().length > 30) {
				val.attr('title', val.html());
				let match = val.html().substr(0, 30);
				val.html(match);
				$(value).find('i').removeClass("fa-angle-up").addClass("fa-angle-down");	
			}			
		});
	}

	$(document).ready(function(){

		function listView() {

			$(".container-fluid #list .table").DataTable({
				debug: true,
				destroy: true,
				searching: true,
				ajax : "{{url('/materiales/etapa')}}" + "/" + $("#etapa").data('id') + "/table",
				columns: [
				{ data: 'original', title: 'Archivo'},
				{ 
					data: 'descripcion',
					title: 'Descripción',
					orderable: false
				},
				{ data: 'updated_at', title: 'Ultima modificación'},
				{ 
					data: 'id_material',
					render: function ( data, type, row, meta ) {
						return tableButtons(data);
					},
					orderable: false
				}
				],
				responsive: true
			});
		}

		listView();

		function gridView() {
			$.ajax({
				url: "{{url('/materiales/etapa')}}" + "/" + $("#etapa").data('id') + "/list",
				success: function (data) {
					$(".container-fluid #grid").html(data);
					descriptionFix();
					changeToDownload();
				},
				error: function (data) {
					alert("Error al cargar documentacion.");
					location.href = "{{url('/dashboard')}}";
				}
			});
		}

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
				span.html(span.attr('title'));
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
			listButton = $(this);
			if (listButton.data("toggle")) {
				listButton.children().removeClass("fa-list").addClass("fa-th");
				$(".container-fluid #list").show();
				$(".container-fluid #configure").hide();
				$(".container-fluid #grid").hide();
				listView();
				listButton.data("toggle", false);
			} else {
				$(".container-fluid #grid").show();
				$(".container-fluid #list").hide();
				$(".container-fluid #configure").show();
				gridView();
				listButton.children().removeClass("fa-th").addClass("fa-list");
				listButton.data("toggle", true);
			}	
		});

	});

</script> 
@if(Auth::user()->id_provincia === 25)
@include('archivos.script')		
@endif
@endsection