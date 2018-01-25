

		<div>
			<form role="form">
				<div class="row" id="busqueda-pautas">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="pauta" class="control-label">Buscar pauta:</label>
						<div class="typeahead__container">
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

		<div>
			<div>
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
									<td>{{$pauta->item}}</td>
									<td>{{$pauta->nombre}}</td>
									<td>{{$pauta->descripcion}}</td>
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

