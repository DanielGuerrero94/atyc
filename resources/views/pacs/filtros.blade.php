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
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="id_estados_ficha">Ficha Tecnica:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control estados_ficha" id="estados_ficha" name="id_estado_ficha" aria-hidden="true" multiple title="Estado de la ficha tecnica">
							<option data-id="1">APROBADA &#10004</option>
							<option data-id="2">EN DISEÑO &#x1F477</option>
							<option data-id="3">NO TIENE &#10060</option>
						</select>          
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<label class="control-label col-xs-5" for="id_accion">Tipo de acción:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control acciones" id="acciones" name="id_accion" aria-hidden="true" multiple>
							@foreach ($tipoAccionesEdit as $tipoAccion)
							<option data-id="{{$tipoAccion->id_linea_estrategica}}" value="{{$tipoAccion->id_linea_estrategica}}">{{$tipoAccion->numero." ".$tipoAccion->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="id_tematica">Tematicas:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control tematicas" id="tematicas" name="id_tematica" aria-hidden="true" multiple>
							@foreach ($tematicasEdit as $tematica)
							<option data-id="{{$tematica->id_area_tematica}}" value="{{$tematica->id_area_tematica}}">{{$tematica->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-sm-4">          
					<label class="control-label col-xs-5" for="id_destinatario">Destinatarios:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control destinatarios" id="destinatarios" name="id_destinatario" aria-hidden="true" multiple>
							@foreach ($destinatariosEdit as $destinatario)
							<option data-id="{{$destinatario->id_destinatario}}" value="{{$destinatario->id_destinatario}}">{{$destinatario->nombre}}</option>
							@endforeach
						</select>          
					</div>
				</div>				
			</div>
			<div class ="row">
				<div class="form-group col-sm-4">
				<label for="id_responsable" class="control-label col-xs-5">Responsables:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control responsables" id="responsables" name="id_responsable" aria-hidden="true" multiple>
							@foreach ($responsablesEdit as $responsable)
							<option data-id="{{$responsable->id_responsable}}" value="{{$responsable->id_responsable}}">{{$responsable->nombre}}</option>
							@endforeach
						</select>				
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
				<label for="id_pauta" class="control-label col-xs-5">Pautas:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control pautas" id="pautas" name="id_pauta" aria-hidden="true" multiple>
							@foreach ($pautasEdit as $pauta)
							<option data-id="{{$pauta->id_pauta}}" value="{{$pauta->id_pauta}}">{{$pauta->nombre}}</option>
							@endforeach
						</select>				
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
				<label for="componente" class="control-label col-xs-5">Componentes CAI:</label>
					<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
						<select class="select-2 form-control componentes" id="componentes" name="id_componente" aria-hidden="true" multiple>
							@foreach ($componentesEdit as $componente)
							<option data-id="{{$componente->id_componente}}" value="{{$componente->id_componente}}">{{$componente->nombre}}</option>
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
				<a href="#abm" class="btn btn-square pull-right filtro" id="filtrar">
					<i class="fa fa-filter text-info fa-lg">Filtrar</i>
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