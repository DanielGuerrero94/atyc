<form>
@if(!isset($disabled))
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-pautas">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="pauta" class="control-label">buscar pauta:</label>
						<div class="typeahead__container">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="pautas_typeahead form-control" name="pauta" type="search" placeholder="nro. item, nombres, descripcion -- min 3 caracteres" autocomplete="off" id="pauta">
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
		<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <label for="pauta" class="control-label col-md-2 col-xs-2">Pauta: </label>
              <div class="col-md-10 col-xs-10">
                <select class="form-control" id="pauta" name="pauta">
                  <option selected disabled>Seleccionar</option>
                  @foreach($pautas as $pauta)
                  <option value="{{$pauta->id_pauta}}" title="{{$pauta->descripcion}}">{{$pauta->nombre . " - " . substr($pauta->descripcion, 0, 70) . "..."}}</option>
				  @endforeach
                </select>
              </div>
            </div>
          </div>
    <br>
@endif
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-default no-padding">
				<div class="box-header">
					<p>Pautas - Cantidad: <b><span id="contador-pautas"></span></b></p>
				</div>
				@if(isset($pac))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="pautas-de-la-pac">
							<thead>
								<tr>
									<th>Número</th>
									<th>Descripción</th>
									@if(!isset($disabled))
									<th>Acciones</th>
                                    @endif
								</tr>
							</thead>
							<tbody>
								@if(isset($pac))
								@foreach($pac->pautas as $pauta)
								<tr>
									<td>{{$pauta->nombre}}</td>
									<td>{{$pauta->descripcion}}</td>
									<td>
                                        @if(!isset($disabled))
                                    <a data-id="{{$pauta->id_pauta}}" class="btn btn-circle quitar" title="Remover"><i class="fa fa-minus text-danger fa-lg"></i></a>
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
