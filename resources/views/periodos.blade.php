@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
			@include('periodos.abm')
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
		
		$('[data-toggle="popover"]').popover(); 
		
		$('#abm .table').DataTable({
			scrollCollapse: true,
			ajax : 'periodos/table',
			columns: [
			{ data: 'nombre'},
			{ data: 'desde'},
			{ data: 'hasta'},
			{ data: 'acciones'}
			]
		});
		
		$('#abm').on('click','#nuevo_periodo',function() {
			$.ajax ({
				url: 'periodos/create',
				success: function(data){
					$('#alta').html(data);
					$('#alta').show();
					$('#abm').hide();
				}
			});
		});
		
		$('#alta').on('click','#volver',function() {
			$('#abm').show();
			$('#alta').hide();
		});
		
	});	
</script>
@endsection