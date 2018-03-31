<form>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-areasTematicas">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="areaTematica" class="control-label">Buscar Area Tematica:</label>
						<div class="typeahead__container">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="areasTematicas_typeahead form-control" name="areaTematica" type="search" placeholder="Nombres areaTematica -- Min 3 caracteres" autocomplete="off" id="areaTematica">
								</span>
							</div>
						</div> 
					</div> 
				</div>
			</form>
		</div>	
	</div>
	<br>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-default no-padding">
				<div class="box-header">
					<p>Areas Tematicas de la Pac - Cantidad: <b><span id="contador-areasTematicas"></span></b></p>
				</div>
				@if(isset($curso))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="areasTematicas-de-la-pac">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($curso))
								@foreach($curso->areasTematicas as $areaTematica)
								<tr>
									<td>{{$areaTematica->nombre}}</td>
									<td>
										@if(!isset($disabled))
										<div class="btn btn-xs btn-info">
											<a href="{{url('/areasTematicas/'.$areaTematica->id_area_tematica)}}">
												<i class="fa fa-search" data-id="{{$areaTematica->id_area_tematica}}"></i>
											</a>
										</div>
										<div class="btn btn-xs btn-danger quitar">
											<i class="fa fa-minus" data-id="{{$areaTematica->id_area_tematica}}"></i>
										</div>
										@endif
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>