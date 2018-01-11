w@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
	@include('reportes.header')
	<div id="filtros" class="col-xs-12">
		@include('reportes.filtros')	
	</div>
	<div id="reporte" data-id-provincia="{{$provincia_usuario->id}}" style="display: none;">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="box box-info ">
				<div class="box-header">
					<h3 class="box-tittle">Reporte
						<div class="btn-group pull-right ">
							<button type="button" class="btn btn-box-tool btn-default excel" title="Excel"><i class="fa fa-file-excel-o text-success" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-box-tool btn-default pdf" title="PDF"><i class="fa fa-file-pdf-o text-danger" aria-hidden="true"></i></button>
						</div>	
						</h3>
				</div>
				<div class="box-body">
					<table id="reporte-table" class="table table-hover">
						<thead>
							<tr>
								<th>Período</th>
								<th>Provincia</th>
								<th>Cantidad de alumnos</th>		
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>	
</div>
@endsection