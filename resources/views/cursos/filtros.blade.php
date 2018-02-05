<div class="box box-info" style="display: none;">
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
			<div class="row">
				<div class="form-group col-sm-4">  		  		
					<label for="nombre" class="control-label col-xs-5">Nombre</label>
					<div class="col-xs-7">
						<input class="form-control" id="nombre" name="nombre">
					</div>
				</div>						
				<div class="form-group col-sm-4">  		  		
					<label for="duracion" class="control-label col-xs-5">Duracion</label>
					<div class="col-xs-7">
						<input class="form-control" id="duracion" name="duracion" type="number">
					</div>
				</div>			
				<div class="form-group col-sm-4">  		  		
					<label for="edicion" class="control-label col-xs-5">Edicion</label>
					<div class="col-xs-7">
						<input class="form-control" id="edicion" name="edicion" type="number">
					</div>						
				</div>			
				@if(Auth::user()->id_provincia == 25)
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="provincia">Provincia:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control" id="provincia" title="Provincia">
							<option data-id="0">Todas las provincias</option>
							@foreach ($provincias as $provincia)
							<option data-id="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
							@endforeach
						</select>          							
					</div>
				</div>			
				@endif
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="linea_estrategica">Tipo de accion:</label>
					<div class="col-xs-7">
						<select class="form-control" id="linea_estrategica" title="Linea estrategica">
							<option data-id="0">Todos los tipos</option>
							@foreach ($lineas_estrategicas as $linea)
							<option data-id="{{$linea->id_linea_estrategica}}">{{$linea->numero}}-{{$linea->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="area_tematica">Areas Tematicas:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control"  id="area_tematica" title="Area tematica">
							<option data-id="0">Todas las tematicas</option>
							@foreach ($areas_tematicas as $area)
							<option data-id="{{$area->id_area_tematica}}">{{$area->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>					
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-sm-4">
					<label for="periodo" class="control-label col-xs-5">Período:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control" id="periodo">
							<option data-id="0" title="Todos los períodos">Todos los períodos</option>
							@foreach ($periodos as $periodo)
							<option data-id="{{$periodo->id_periodo}}" title="{{$periodo->nombre}}">{{$periodo->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>		
			<div class="row">
				<div class="form-group col-sm-4" id="toggle-fecha">
					<p>Especificar fecha:  <i class="fa fa-toggle-off btn"></i></p>
				</div>
			</div>
			<br>
			<div class="row" style="display: none;">
				<div class="form-group col-sm-6">
					<label class="col-xs-2">Desde:</label>
					<div class="input-group date col-xs-8" style="width: 300px">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="desde" id="desde" class="form-control pull-right datepicker">
					</div>
				</div>
				<div class="form-group col-sm-6">
					<label class="col-xs-2">Hasta:</label>
					<div class="input-group date col-xs-8" style="width: 300px">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="hasta" id="hasta" class="form-control pull-right datepicker">
					</div>
				</div>
			</div>				
			<div class="box-footer">	
				<a href="#" class="btn btn-square pull-right filtro" id="filtrar">
					<i class="fa fa-filter text-info fa-lg"> Filtrar</i>
				</a>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {

		$('#toggle-fecha').on('click',function () {

			var icono = $(this).find('i');

			switchIcon(icono,'fa-toggle-off','fa-toggle-on');

			var periodo = $('#periodo').closest('.row');
			var fecha = $('.fa-calendar').closest('.row');			

			showCalendarInputs(periodo,fecha);
		});			
	});
</script>
