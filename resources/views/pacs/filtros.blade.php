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
					<label class="control-label col-xs-5" for="id_tipo_accion">Tipo de acción:</label>
					<div class="col-xs-7">
						<select class="form-control" id="id_tipo_accion" title="Tipo de Acción">
							<option data-id="">Todos los tipos</option>
							@foreach ($tipoAcciones as $tipoAccion)
							<option data-id="{{$tipoAccion->id_accion}}">{{$tipoAccion->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
				<div class="form-group col-sm-4">  		  		
					<label for="duracion" class="control-label col-xs-5">Duración</label>
					<div class="col-xs-7">
						<input class="form-control" id="duracion" name="duracion" type="number">
					</div>						
				</div>			
				@if(Auth::user()->id_provincia == 25)
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="id_provincia">Provincia:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control" id="id_provincia" title="Provincia">
							<option data-id="0">Todas las provincias</option>
							@foreach ($provincias as $provincia)
							<option data-id="{{$provincia->id_provincia}}">{{$provincia->nombre}}</option>
							@endforeach
						</select>          							
					</div>
				</div>			
				@endif
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="id_tematica">Tematicas:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control"  id="id_tematica" title="Tematica">
							<option data-id="">Todas las tematicas</option>
							@foreach ($tematicas as $tematica)
							<option data-id="{{$tematica->id_tematica}}">{{$tematica->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="id_destinatario">Destinatarios:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control"  id="id_destinatario" title="Destinatario">
							<option data-id="">Todos los destinatarios</option>
							@foreach ($destinatarios as $destinatario)
							<option data-id="{{$destinatario->id_destinatario}}">{{$destinatario->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>				
			</div>
			<hr>
			<div class ="row">
				<div class="form-group col-sm-4">
				<label for="id_responsable" class="control-label col-xs-5">Responsable:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control" id="id_responsable">
							<option data-id="0" title="Todos los responsables">Todos los responsables</option>
							@foreach ($responsables as $responsable)
							<option data-id="{{$responsable->id_responsable}}" title="{{$responsable->nombre}}">{{$responsable->nombre}}</option>
							@endforeach
						</select>				
					</div>
				</div>
				<div class="form-group col-sm-4">
				<label for="id_pauta" class="control-label col-xs-5">Pauta:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control" id="pauta">
							<option data-id="0" title="Todas las pautas">Todas las pautas</option>
							@foreach ($pautas as $pauta)
							<option data-id="{{$pauta->id_pauta}}" title="{{$pauta->nombre}}">{{$pauta->nombre}}</option>
							@endforeach
						</select>				
					</div>
				</div>
				<div class="form-group col-sm-4">
				<label for="componente" class="control-label col-xs-5">Componente CAI:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="form-control" id="componente">
							<option data-id="0" title="Todos los componentes">Todos los componentes</option>
							@foreach ($componentes as $componente)
							<option data-id="{{$componente->id_componente}}" title="{{$componente->nombre}}">{{$componente->nombre}}</option>
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
						<select class="form-control" id="id_periodo">
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
				<a href="#" class="btn btn-square pull-right filtroPac" id="filtrarPAC">
					<i class="fa fa-filter text-info fa-lg"> Filtrar PAC</i>
				</a>
				<a href="#" class="btn btn-square pull-right filtroAcciones" id="filtrarAcciones">
					<i class="fa fa-address-book fa-lg"> Filtrar Acciones</i>
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