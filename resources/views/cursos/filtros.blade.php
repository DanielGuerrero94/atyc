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
			<div class="row">
				<div class="form-group col-xs-4 col-sm-4 col-md-4 col-lg-4">  		  		
					<label for="nombre" class="control-label col-xs-5">Nombre:</label>
					<div class="typeahead__container col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<div class="typeahead__field">             
                  			<span class="typeahead__query">
								<input class="curso_filtro_typeahead form-control" id="nombre" name="nombre" type="search" placeholder="Todos los nombres" autocomplete="off" style="font-size:1.4rem;">
							</span>
						</div>
					</div>
				</div>						
				<div class="form-group col-sm-4">
					<label for="duracion" class="control-label col-xs-5">Duración:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<input class="form-control" id="duracion" name="duracion" type="number" placeholder="Todas las duraciones">
					</div>
				</div>
				<div class="form-group col-sm-4">
					<label for="ediciones" class="control-label col-xs-5">Ediciones:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<input class="form-control" id="edicion" name="edicion" type="number" placeholder="Todas las ediciones">
					</div>
				</div>
			</div>
			<br>
			@if(Auth::user()->id_provincia == 25)
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="provincia">Provincia/s:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select2 form-control provincias" id="provincias" name="id_provincia" title="Provincias" aria-hidden="true" multiple>
							@foreach ($provincias_edit as $provincia)
							<option data-id="{{$provincia->id_provincia}}" value="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
			</div>
			@endif
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="linea_estrategica">Tipo/s de acción:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select2 form-control lineas_estrategicas" id="lineas_estrategicas" name="id_linea_estrategica" title="Tipos de acción" aria-hidden="true" multiple>
							@foreach ($lineas_estrategicas_edit as $linea)
							<option data-id="{{$linea->id_linea_estrategica}}" value="{{$linea->id_linea_estrategica}}">{{$linea->numero." ".$linea->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="area_tematica">Temática/s:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select2 form-control tematicas" id="tematicas" name="id_tematica" title="Tematicas" aria-hidden="true" multiple>
							@foreach ($areas_tematicas_edit as $area)
							<option data-id="{{$area->id_area_tematica}}" value="{{$area->id_area_tematica}}">{{$area->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="estado">Estados:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select2 form-control estados" id="estados" name="id_estado" title="Estados" aria-hidden="true" multiple>
							@foreach ($estados_edit as $estado)
							<option data-id="{{$estado->id_estado}}" value="{{$estado->id_estado}}">{{$estado->nombre}}</option>
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
						<select class="select2 form-control periodos" id="periodo" name="id_periodo" aria-hidden="true">
							<option></option>
							@foreach ($periodos_edit as $periodo)
							<option data-id="{{$periodo->id_periodo}}" value="{{$periodo->id_periodo}}">{{$periodo->nombre}}</option>
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

			if($('#periodo').val()) {
				$('#periodo').val(undefined);
				$('.periodos').select2({
					"placeholder": "Todos los periodos",
					width: "400%"
				});
			} else {
				$('#desde').val(undefined);
				$('#hasta').val(undefined);
			}
		});			
	});
</script>
