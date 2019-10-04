@extends('layouts.adminlte')

@section('content')
<div class="container">
	<div id="filtros" style="display: none;"></div>
	<div id="abm">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h2 class="box-tittle">Gestores</h2>
				</div>
				<div class="box-body">
					<table id="abm-table" class="table table-hover"/>
					<div class="box-footer">
					<a class="btn btn-success pull-right" href="{{url('/registrar')}}">Registrar</a>
				</div>
				</div>			
			</div>			
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function(){

		$('#abm-table').DataTable({
			ajax : 'gestores/tabla',
			columns: [
			{ data: 'name', title: 'Usuario'},
			{ data: 'title', title: 'Descripcion'},
			{ data: 'email', title: 'Email'},
			{ data: 'acciones', title: 'Acciones'}
			]
		});

	});

</script> 
@endsection

