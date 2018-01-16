<form>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-pautas">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="pauta" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Buscar pauta:</label>
						<div class="typeahead__container col-xs-10 col-sm-10 col-md-10 col-lg-10">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="pautas_typeahead form-control" name="pauta" type="search" placeholder="Nro. Item, nombres, descripcion -- Min 3 caracteres" autocomplete="off" id="pauta">
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
					<p>Pautas de la Pac - Cantidad: <b><span id="contador-pautas"></span></b></p>
				</div>
				@if(isset($pac))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="pautas-de-la-pac">
							<thead>
								<tr>
									<th>Item</th>
									<th>Nombre</th>
									<th>Descripcion</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($pac))
								@foreach($pac->pautas as $pauta)
								<tr>
									<td>{{$pauta->nombres}}</td>
									<td>{{$pauta->apellidos}}</td>
									<td>{{$pauta->nro_doc}}</td>
									<td>
										<div class="btn btn-xs btn-info">
											<a href="{{url('/pautas/'.$pauta->id_pauta)}}">
												<i class="fa fa-search" data-id="{{$pauta->id_pauta}}"></i>
											</a>
										</div>
										<div class="btn btn-xs btn-danger quitar">
											<i class="fa fa-minus"></i>
										</div>
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
	</div>
</form>