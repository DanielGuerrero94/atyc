<form>
    <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form role="form">
				<div class="row" id="busqueda-destinatarios">
					<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">  
						<label for="destinatario" class="control-label">Buscar destinatarios:</label>
						<div class="typeahead__container">
							<div class="typeahead__field">             
								<span class="typeahead__query">
									<input class="destinatarios_typeahead form-control" name="destinatario" type="search" placeholder="Nombre -- Min 3 caracteres" autocomplete="off" id="destinatario">
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
					<p>Destinatarios - Cantidad: <b><span id="contador-destinatarios"></span></b></p>
				</div>
				@if(isset($pac))
				<div class="box-body">
					@else
					<div class="box-body" style="display: none;">
						@endif
						<table class="table table-striped" id="destinatarios-de-la-pac">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($pac))
								@foreach($pac->funciones as $funcion)
								<tr>
									<td>{{$funcion->nombre}}</td>
									<td>
										<div class="btn btn-xs btn-info">
											<a href="{{url('/funciones/'.$funcion->id_funcion)}}">
												<i class="fa fa-search" data-id="{{$funcion->id_funcion}}"></i>
											</a>
										</div>
										<div class="btn btn-xs btn-danger quitar">
											<i class="fa fa-minus" data-id="{{$funcion->id_funcion}}"></i>
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
    </form>
