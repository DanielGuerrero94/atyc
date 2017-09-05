@extends('layouts.adminlte')

@section('content')
<div class="row">
	<div id="abm" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1">
		@include('tipoDocentes.abm')
	</div>
</div>
<div class="row">
	<div id="alta" class="col-xs-12 col-sm-12 col-md-12 col-lg-10 col-lg-offset-1" style="display: none;">
	</div>		
</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#abm .table').DataTable({
			scrollCollapse: true,
			ajax : 'tipoDocentes/table',
			columns: [
			{ data: 'id_tipo_docente'},
			{ data: 'nombre'},
			{ data: 'acciones'}
			]
		});

		$('#abm').on('click','#nuevo_tipo_docente',function() {
			$.ajax ({
				url: 'tipoDocentes/create',
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