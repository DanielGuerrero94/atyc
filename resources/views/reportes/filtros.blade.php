<div class="box box-info">
	<div class="box-header with-border">
		<h2 class="box-title">Filtros</h2>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div>
	</div>
	<div class="box-body">
		<form id="form-filtros">
			@if(Auth::user()->id_provincia == 25)
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label for="provincia" class="control-label col-xs-4 col-sm-2">Provincia:</label>
					<div class="col-xs-8 col-sm-6">
						<select class="form-control" id="provincia" name="id_provincia">
							<option data-id="0" title="Todas las provincias" value="0">Todas las provincias</option>
							@foreach ($provincias as $provincia)
							<option data-id="{{$provincia->id_provincia}}" title="{{$provincia->titulo}}" value="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>									
							@endforeach
						</select>
					</div>
				</div>	
			</div>
			@endif
			<div class="row">
				<div class="form-group col-xs-12 col-sm-6">
					<label for="periodo" class="control-label col-xs-4 col-sm-2">Período:</label>
					<div class="col-xs-8 col-sm-6">
						<select class="form-control" id="periodo" name="id_periodo">
							<option data-id="0" title="Todos los períodos" value="0">Todos los períodos</option>
							@foreach ($periodos as $periodo)
							<option data-id="{{$periodo->id_periodo}}" title="{{$periodo->nombre}}" value="{{$periodo->id_periodo}}">{{$periodo->nombre}}</option>									
							@endforeach
						</select>
					</div>
				</div>						
			</div>
			<div class="row" id="toggle-fecha">
				<div class="form-group col-sm-6">
					<p>Especificar fecha:  <i class="fa fa-toggle-off btn"></i></p>
				</div>
			</div>
			<div class="row" style="display: none;">
				<div class="form-group col-xs-12 col-sm-6">
					<label class="col-xs-4 col-sm-2">Desde:</label>
					<div class="input-group date col-xs-8 col-sm-8">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="desde" id="desde" class="form-control pull-right datepicker">
					</div>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<label class="col-xs-4 col-sm-2">Hasta:</label>
					<div class="input-group date col-xs-8 col-sm-8">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="hasta" id="hasta" class="form-control pull-right datepicker">
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">	
			<button class="btn btn-danger pull-right" id="limpiar" style="display: none"><i class="fa fa-eraser"></i></button>
			<div class="btn btn-info pull-right" id="filtrar"><i class="fa fa-filter"></i>Filtrar</div>		
		</div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('#toggle-fecha').on('click',function () {

			var icono = $(this).find('i');

			switchIcon(icono,'fa-toggle-off','fa-toggle-on');
			
			var periodo = $('#periodo').closest('.row');
			var fecha = $('.fa-calendar').closest('.row');			
			
			showCalendarInputs(periodo,fecha);
		});	
		
	});
</script>