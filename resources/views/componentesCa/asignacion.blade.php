<form>
										@if(!isset($disabled))
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-componentesCa">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="componenteCa" class="control-label">Buscar ComponenteCA:</label>
						<div class="typeahead__container">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="componentesCa_typeahead form-control" name="componenteCa" type="search" placeholder="Nombre  -- Min 3 caracteres" autocomplete="off" id="componenteCa">
								</span>
							</div>
						</div> 
					</div> 
				</div>
			</form>
		</div>				
	</div>
    <br>
@endif
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box box-default no-padding">
				<div class="box-header">
					<p>Componentes CA - Cantidad: <b><span id="contador-componenteCa"></span></b></p>
				</div>
				@if(isset($pac))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="componentesCa-de-la-pac">
							<thead>
								<tr>
									<th>Nombre</th>
										@if(!isset($disabled))
                                    <th>Acciones</th>
@endif
								</tr>
							</thead>
							<tbody>
								@if(isset($pac))
								@foreach($pac->componentesCa as $componenteCa)
								<tr>
									<td>{{$componenteCa->nombre}}</td>
									<td>
                                        @if(!isset($disabled))
									<a data-id="{{$componenteCa->id_componente_ca}}" class="btn btn-circle quitar" title="Remover"><i class="fa fa-minus text-danger fa-lg"></i></a>
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

