@extends('layouts.adminlte')

@section('script')
<!-- InputMask -->
<script src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js")}}"></script>
<script src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js")}}"></script>
<script src="{{asset("/bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js")}}"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{asset("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>
<!-- bootstrap time picker -->
<script src="{{asset("/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js")}}"></script>

<script type="text/javascript">

	$(document).ready(function () {
		//Permitir o no manejar por fechas
		$(".checkbox").on("click",function () {
			$("#desde").prop('disabled', function(){
				return true;
			});
			$("#hasta").prop('disabled', function(_,attr){
				console.log(attr=='disabled');
				return !(attr=='disabled');});
		});		
	});

</script>
@endsection

@section('content')
<div class="row">	
	<div class="col-md-6 col-md-offset-3" style="margin-top: 20px">
		<div class="box box-info">
			<div class="box-header with-border">Reportes</div>
			<form role="form">
				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="provincia">Provincia:</label>
							<select class="form-control" id="provincia">
								<option>Elegir...</option>
								@foreach ($provincias as $provincia)
								<option>{{$provincia->descripcion}}</option>
								@endforeach
							</select>
						</div>		
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="periodo">Periodo:</label>
							<select class="form-control" id="periodo">
								<option>Elegir...</option>
								<option>Todos los periodos</option>
								@foreach ($periodos as $periodo)
								<option>{{$periodo->descripcion}}</option>
								@endforeach
							</select>
						</div>		
					</div>
					<div class="checkbox">
						<label><input type="checkbox" name="fecha">Especificar rango de fecha</label>				
					</div>
					<input type="text" id="desde">
					<input type="text" id="hasta">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" id="reservation">
					</div>
				</div>
				<div class="box-footer">
					<button class="btn btn-danger pull-right" id="limpiar"  style="display: none"><i class="fa fa-eraser"></i>Limpiar</button> 			
					<button type="submit" class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</button>					
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
