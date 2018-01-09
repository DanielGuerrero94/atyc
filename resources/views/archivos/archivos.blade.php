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

	});

</script> 
@if(Auth::user()->id_provincia === 25)
@include('archivos.script')		
@endif
@endsection

